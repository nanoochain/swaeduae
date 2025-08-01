# Reference node implementation for NanooChain.
#
# This Flask application exposes a simple HTTP API for interacting
# with the NanooChain blockchain. It supports wallet generation,
# submitting new transactions, mining blocks, querying the chain and
# retrieving balances. Transactions are verified upon submission
# using ECDSA signatures.

from flask import Flask, request, jsonify
from uuid import uuid4
import requests
import hashlib
import json

from .blockchain import Blockchain, Block
from .wallet import generate_wallet, verify_signature
from .wallet import sign_transaction as wallet_sign
from .wallet import address_from_public_key
from .config import PORT, MINER_ADDRESS
from . import pool  # mining pool backend
from .miner import mine_block
from . import auth  # authentication and JWT utilities

# A simple Flask node to interact with the blockchain
app = Flask(__name__)

# Unique identifier for this node instance
node_id = str(uuid4()).replace('-', '')

# Global blockchain state and pending transaction pool
blockchain = Blockchain()

# In-memory mempool of pending transactions. Each transaction
# includes sender, recipient, amount, public_key and signature to
# allow post‑hoc validation if needed. For a production system, a
# persistent mempool (e.g. backed by a database or file) should be
# used instead.
MEMPOOL: list = []

# Set of known peer nodes (for network discovery in later phases)
PEERS = set()

# ---------------------------------------------------------------------------
# Helper functions for node networking and consensus
# ---------------------------------------------------------------------------

def _valid_chain(chain: list) -> bool:
    """Check whether a given chain (list of dict blocks) is valid.

    A valid chain has contiguous indices and each block's
    ``previous_hash`` matches the computed hash of the previous block.
    Difficulty validation is omitted for simplicity.

    Args:
        chain: A list of block dictionaries.

    Returns:
        True if the chain is valid, False otherwise.
    """
    if not chain:
        return False
    for i in range(1, len(chain)):
        prev = chain[i - 1]
        curr = chain[i]
        # Verify linkage
        prev_hash = hashlib.sha256(json.dumps(prev, sort_keys=True).encode()).hexdigest()
        if curr.get('previous_hash') != prev_hash:
            return False
    return True


def _resolve_conflicts() -> bool:
    """Consensus algorithm: replace chain with the longest valid chain from peers.

    Returns:
        True if the chain was replaced, False otherwise.
    """
    global blockchain
    max_length = len(blockchain.chain)
    new_chain = None
    for peer in PEERS:
        try:
            res = requests.get(f"http://{peer}/chain", timeout=5)
            if res.status_code == 200:
                peer_chain = res.json()
                # Support both list-only and {'length': X, 'chain': [...]}
                if isinstance(peer_chain, dict):
                    chain_data = peer_chain.get('chain', [])
                else:
                    chain_data = peer_chain
                length = len(chain_data)
                if length > max_length and _valid_chain(chain_data):
                    max_length = length
                    new_chain = chain_data
        except Exception:
            continue
    if new_chain:
        # Rebuild Block objects from dicts
        rebuilt = []
        for blk in new_chain:
            block_obj = Blockchain().chain[0]  # placeholder to satisfy type, will be overwritten
            block_obj = block_obj.__class__(
                index=blk['index'],
                transactions=blk['transactions'],
                previous_hash=blk['previous_hash'],
                nonce=blk.get('nonce', 0),
                timestamp=blk.get('timestamp'),
            )
            block_obj.hash = blk.get('hash')
            rebuilt.append(block_obj)
        blockchain.chain = rebuilt
        blockchain.save_chain()
        return True
    return False


@app.route('/wallet/new', methods=['GET'])
def new_wallet():
    """Generate and return a new wallet."""
    return jsonify(generate_wallet())


@app.route('/transaction/new', methods=['POST'])
def new_transaction():
    """Submit a new transaction to the mempool.

    Expects a JSON payload containing ``sender`` (the base58 address),
    ``recipient`` (the base58 address), ``amount`` (numeric),
    ``public_key`` (hex string of the sender's public key) and
    ``signature`` (hex string). The transaction is validated using
    the provided signature. If valid, it is stored in the mempool
    and will be included in the next mined block.
    """
    tx = request.get_json() or {}
    required = ["sender", "recipient", "amount", "public_key", "signature"]
    if not all(k in tx for k in required):
        return jsonify({'error': 'Missing fields'}), 400

    # Construct the payload used for signature verification. Note
    # that the signature should only sign the core transaction fields,
    # not the public key or signature themselves.
    tx_payload = {
        "sender": tx['sender'],
        "recipient": tx['recipient'],
        "amount": tx['amount'],
    }

    # Verify the signature against the supplied public key
    if not verify_signature(tx['public_key'], tx_payload, tx['signature']):
        return jsonify({'error': 'Invalid transaction signature'}), 400

    # Store the full transaction (including signature and public key)
    MEMPOOL.append({
        "sender": tx['sender'],
        "recipient": tx['recipient'],
        "amount": tx['amount'],
        "public_key": tx['public_key'],
        "signature": tx['signature'],
    })
    return jsonify({'message': 'Transaction will be added to the next block'}), 201


@app.route('/transaction/send', methods=['POST'])
def send_transaction():
    """Create and sign a transaction using a private key.

    This helper endpoint simplifies transaction creation for front‑end
    clients by performing signing server‑side. The caller must supply
    ``recipient``, ``amount`` and the sender's ``private_key``. The
    sender's public key and address are derived from the private key.

    The resulting transaction is added to the mempool and the signed
    transaction is returned.
    """
    data = request.get_json() or {}
    required = ['recipient', 'amount', 'private_key']
    if not all(k in data for k in required):
        return jsonify({'error': 'Missing fields'}), 400
    try:
        private_key_hex = data['private_key']
        # Derive public key from private key.  We import ecdsa here to avoid
        # circular imports at module level.
        import ecdsa
        sk = ecdsa.SigningKey.from_string(bytes.fromhex(private_key_hex), curve=ecdsa.SECP256k1)
        vk = sk.get_verifying_key()
        public_key_hex = vk.to_string().hex()
        # Derive sender address from public key
        sender_address = address_from_public_key(public_key_hex)
        tx_payload = {
            'sender': sender_address,
            'recipient': data['recipient'],
            'amount': data['amount'],
        }
        signature_hex = wallet_sign(private_key_hex, tx_payload)
        # Add to mempool
        MEMPOOL.append({
            'sender': sender_address,
            'recipient': data['recipient'],
            'amount': data['amount'],
            'public_key': public_key_hex,
            'signature': signature_hex,
        })
        return jsonify({
            'sender': sender_address,
            'recipient': data['recipient'],
            'amount': data['amount'],
            'public_key': public_key_hex,
            'signature': signature_hex,
            'message': 'Transaction created and added to mempool'
        }), 201
    except Exception as exc:
        return jsonify({'error': f'Failed to create transaction: {exc}'}), 400


@app.route('/transactions/history/<address>', methods=['GET'])
def transaction_history(address: str):
    """Return all confirmed and pending transactions for a given address.

    The history includes transactions where the address appears as
    sender or recipient. Both confirmed (in blocks) and pending
    transactions in the mempool are included. Note that mining reward
    transactions do not include signatures and will only list the
    recipient and amount.
    """
    history = []
    # Search confirmed blocks
    for blk in blockchain.chain:
        for tx in blk.transactions:
            if isinstance(tx, dict):
                if tx.get('sender') == address or tx.get('recipient') == address:
                    history.append({
                        'block_index': blk.index,
                        **tx
                    })
    # Include pending transactions
    for tx in MEMPOOL:
        if tx['sender'] == address or tx['recipient'] == address:
            history.append({
                'block_index': None,
                **tx
            })
    return jsonify(history), 200


@app.route('/transactions/pending', methods=['GET'])
def pending_transactions():
    """Return all pending transactions in the mempool."""
    return jsonify(MEMPOOL)


@app.route('/mine', methods=['GET'])
def mine():
    """Mine a new block if there are pending transactions."""
    # Use the configured miner address for the reward transaction
    block = mine_block(blockchain, MINER_ADDRESS, MEMPOOL)
    if block:
        return jsonify({
            "index": block.index,
            "transactions": block.transactions,
            "previous_hash": block.previous_hash,
            "nonce": block.nonce,
            "hash": block.hash,
            "timestamp": block.timestamp
        }), 200
    return jsonify({'message': 'No transactions to mine'}), 200


@app.route('/chain', methods=['GET'])
def full_chain():
    """Return the full blockchain as a list of blocks."""
    return jsonify([{
        "index": b.index,
        "transactions": b.transactions,
        "previous_hash": b.previous_hash,
        "nonce": b.nonce,
        "hash": b.hash,
        "timestamp": b.timestamp
    } for b in blockchain.chain]), 200


@app.route('/balance/<address>', methods=['GET'])
def balance(address: str):
    """Query the balance of a given address."""
    return jsonify({'address': address, 'balance': blockchain.get_balance(address)})


@app.route('/peers', methods=['GET'])
def get_peers():
    """List known peer nodes."""
    return jsonify(list(PEERS))


@app.route('/add_peer', methods=['POST'])
def add_peer():
    """Register a new peer node.

    Expects a JSON payload with a ``peer`` field containing the
    peer's URL. The peer is added to the local peer set.
    """
    data = request.get_json() or {}
    peer = data.get("peer")
    if peer:
        PEERS.add(peer)
        return jsonify({"message": f"Peer {peer} added."}), 201
    return jsonify({"error": "No peer provided"}), 400


# ---------------------------------------------------------------------------
# Phase 2 endpoints for network & node infrastructure
# ---------------------------------------------------------------------------

@app.route('/nodes/register', methods=['POST'])
def register_nodes():
    """Register one or more new peer nodes.

    Expects JSON of the form ``{"nodes": ["host1:port", "host2:port", ...]}``.
    Each address will be normalised and added to the local peer set.
    """
    values = request.get_json() or {}
    nodes = values.get('nodes')
    if not nodes or not isinstance(nodes, list):
        return jsonify({'error': 'Please supply a list of node addresses'}), 400
    for node in nodes:
        # Normalise the address by removing scheme, if present
        address = node
        if address.startswith('http://'):
            address = address[len('http://'):]
        elif address.startswith('https://'):
            address = address[len('https://'):]
        PEERS.add(address)
    return jsonify({'message': 'Nodes registered', 'total_nodes': list(PEERS)}), 201


@app.route('/nodes/resolve', methods=['GET'])
def consensus():
    """Resolve conflicts by replacing our chain with the longest valid one from peers."""
    replaced = _resolve_conflicts()
    if replaced:
        return jsonify({'message': 'Our chain was replaced', 'new_length': len(blockchain.chain)}), 200
    return jsonify({'message': 'Our chain is authoritative', 'length': len(blockchain.chain)}), 200


# Optional: simple explorer endpoints for front‑end queries
@app.route('/explorer/block/<int:index>', methods=['GET'])
def explore_block(index: int):
    """Return a block by its index if it exists."""
    if 0 <= index < len(blockchain.chain):
        blk = blockchain.chain[index]
        return jsonify({
            'index': blk.index,
            'timestamp': blk.timestamp,
            'transactions': blk.transactions,
            'previous_hash': blk.previous_hash,
            'nonce': blk.nonce,
            'hash': blk.hash,
        }), 200
    return jsonify({'error': 'Block not found'}), 404


@app.route('/explorer/transaction/<signature>', methods=['GET'])
def explore_transaction(signature: str):
    """Search for a transaction by its signature and return the block and transaction if found."""
    for blk in blockchain.chain:
        for tx in blk.transactions:
            # Reward transactions do not include signatures
            if isinstance(tx, dict) and tx.get('signature') == signature:
                return jsonify({'block_index': blk.index, 'transaction': tx}), 200
    return jsonify({'error': 'Transaction not found'}), 404


@app.route('/stats', methods=['GET'])
def stats():
    """Return basic node statistics."""
    latest_hash = blockchain.chain[-1].hash if blockchain.chain else None
    return jsonify({
        'num_blocks': len(blockchain.chain),
        'latest_hash': latest_hash,
        'num_peers': len(PEERS),
        'mempool_size': len(MEMPOOL)
    }), 200


# ---------------------------------------------------------------------------
# Phase 5: Authentication and user management
# ---------------------------------------------------------------------------

@app.route('/auth/signup', methods=['POST'])
def auth_signup():
    """Create a new user account.

    The request must include ``username`` and ``password``.  An
    optional ``role`` field can be supplied to assign a role (e.g.
    ``admin``).  The server returns a TOTP secret that the user must
    configure in their authenticator app to perform two‑factor
    authentication.
    """
    data = request.get_json() or {}
    username = data.get('username')
    password = data.get('password')
    role = data.get('role', 'user')
    if not username or not password:
        return jsonify({'error': 'username and password are required'}), 400
    success, secret = auth.create_user(username, password, role)
    if not success:
        return jsonify({'error': 'User already exists'}), 400
    return jsonify({'message': 'User created', 'totp_secret': secret}), 201


@app.route('/auth/login', methods=['POST'])
def auth_login():
    """Authenticate a user and return a JWT token.

    The request must include ``username``, ``password`` and
    ``totp_code``.  On successful verification a token is returned
    which must be included in the ``Authorization`` header for
    protected endpoints.
    """
    data = request.get_json() or {}
    username = data.get('username')
    password = data.get('password')
    totp_code = data.get('totp_code')
    if not username or not password or not totp_code:
        return jsonify({'error': 'username, password and totp_code are required'}), 400
    user = auth.verify_user(username, password)
    if not user:
        return jsonify({'error': 'Invalid credentials'}), 401
    if not auth.verify_totp(user['totp_secret'], str(totp_code)):
        return jsonify({'error': 'Invalid TOTP code'}), 401
    token = auth.jwt_encode({'username': user['username'], 'role': user['role']})
    return jsonify({'token': token, 'role': user['role']}), 200


# ---------------------------------------------------------------------------
# Phase 4: Mining pool endpoints
# ---------------------------------------------------------------------------

@app.route('/pool/register_miner', methods=['POST'])
def pool_register_miner():
    """Register a new miner with the pool.

    Expects JSON with ``name``.  Returns a unique ``miner_id``.
    """
    data = request.get_json() or {}
    name = data.get('name')
    if not name:
        return jsonify({'error': 'Name is required'}), 400
    miner_id = pool.register_miner(name)
    return jsonify({'miner_id': miner_id}), 201


@app.route('/pool/get_work', methods=['GET'])
def pool_get_work():
    """Return a mining job for the pool.  The client uses the returned
    ``index``, ``previous_hash`` and ``transactions`` along with a nonce
    to compute a hash.  A valid share must start with the specified
    ``target_prefix``.
    """
    work = pool.get_work(blockchain, MEMPOOL)
    return jsonify(work), 200


@app.route('/pool/submit_share', methods=['POST'])
def pool_submit_share():
    """Submit a mined share.  The request must include ``miner_id`` and
    ``nonce``.  The pool will reconstruct the work at submission time.

    If the share meets the pool difficulty, it will be recorded and
    possibly mine a full block if it meets the network difficulty.
    """
    data = request.get_json() or {}
    miner_id = data.get('miner_id')
    nonce = data.get('nonce')
    if not miner_id or nonce is None:
        return jsonify({'error': 'miner_id and nonce are required'}), 400
    # Recreate the current work description.  In a real pool, the
    # work used by the miner would be stored and verified to avoid
    # mismatches when the mempool changes.  For simplicity we
    # regenerate the work here.
    work = pool.get_work(blockchain, MEMPOOL)
    try:
        nonce_int = int(nonce)
    except Exception:
        return jsonify({'error': 'Invalid nonce'}), 400
    result = pool.submit_share(miner_id, nonce_int, work, blockchain, MEMPOOL)
    status = 201 if result.get('accepted') else 400
    return jsonify(result), status


@app.route('/pool/stats', methods=['GET'])
@auth.jwt_required(role='admin')
def pool_stats_endpoint():
    """Return aggregate statistics about the pool.

    This endpoint is restricted to admin users via the ``jwt_required``
    decorator.  Clients must include a valid JWT token in the
    ``Authorization`` header with the ``admin`` role.
    """
    stats_data = pool.pool_stats()
    return jsonify(stats_data), 200


if __name__ == '__main__':
    import os
    os.makedirs("data", exist_ok=True)
    app.run(host='0.0.0.0', port=PORT)