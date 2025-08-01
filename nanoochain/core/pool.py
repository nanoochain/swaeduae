"""
Mining pool backend for NanooChain.

This module provides simple functions to support a mining pool.  It
stores registered miners and submitted shares in a SQLite database and
provides helpers for registering miners, generating mining work and
submitting shares.  Shares that solve the full network difficulty
result in a new block being mined on the underlying blockchain.

The pool does not implement payouts or dynamic difficulty tuning, but
it lays the foundation for a community‑driven mining ecosystem.
"""

import os
import sqlite3
import uuid
import json
import hashlib
import time
from datetime import datetime
from typing import Dict, Any

from .config import POOL_DB_PATH, POOL_DIFFICULTY_PREFIX, DIFFICULTY, MINER_ADDRESS
from .miner import mine_block


# Ensure the data directory exists
os.makedirs(os.path.dirname(POOL_DB_PATH), exist_ok=True)

# Create a global SQLite connection.  ``check_same_thread=False`` allows
# usage from multiple threads (Flask worker threads).  Each function
# acquires its own cursor and commits changes.
_conn = sqlite3.connect(POOL_DB_PATH, check_same_thread=False)


def _init_db():
    """Initialise the pool database with required tables."""
    cur = _conn.cursor()
    # Create miners table
    cur.execute(
        """
        CREATE TABLE IF NOT EXISTS miners (
            miner_id TEXT PRIMARY KEY,
            name TEXT NOT NULL,
            join_date TEXT NOT NULL,
            total_shares INTEGER DEFAULT 0
        )
        """
    )
    # Create shares table
    cur.execute(
        """
        CREATE TABLE IF NOT EXISTS shares (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            miner_id TEXT NOT NULL,
            share_hash TEXT NOT NULL,
            difficulty INTEGER NOT NULL,
            timestamp TEXT NOT NULL,
            FOREIGN KEY(miner_id) REFERENCES miners(miner_id)
        )
        """
    )
    _conn.commit()


# Initialise the database when the module is imported
_init_db()


def register_miner(name: str) -> str:
    """Register a new miner and return a unique miner ID."""
    miner_id = str(uuid.uuid4())
    join_date = datetime.utcnow().isoformat()
    cur = _conn.cursor()
    cur.execute(
        "INSERT INTO miners (miner_id, name, join_date, total_shares) VALUES (?, ?, ?, 0)",
        (miner_id, name, join_date),
    )
    _conn.commit()
    return miner_id


def get_work(blockchain: Any, mempool: list) -> Dict[str, Any]:
    """Generate a mining job for miners.

    A mining job consists of the next block index, previous block
    hash, serialised list of pending transactions and the share
    difficulty prefix that defines how many leading hex zeros a valid
    share must have.

    Args:
        blockchain: The current Blockchain object.
        mempool: The list of pending transactions.

    Returns:
        A dictionary describing the work to be mined.
    """
    previous_hash = blockchain.chain[-1].hash if blockchain.chain else '0'
    next_index = blockchain.chain[-1].index + 1 if blockchain.chain else 0
    # Serialise the transaction list deterministically
    tx_serialised = json.dumps(mempool, sort_keys=True)
    return {
        'index': next_index,
        'previous_hash': previous_hash,
        'transactions': tx_serialised,
        'target_prefix': POOL_DIFFICULTY_PREFIX,
    }


def submit_share(miner_id: str, nonce: int, work: Dict[str, Any], blockchain: Any, mempool: list) -> Dict[str, Any]:
    """Submit a mined share to the pool.

    The pool verifies whether the provided nonce produces a hash with
    the required prefix.  If it does, the share is recorded in the
    database and, if the hash also meets the full network difficulty,
    a new block is mined onto the blockchain.

    Args:
        miner_id: The registered miner's unique ID.
        nonce: The nonce used to compute the hash.
        work: The work dictionary previously obtained from ``get_work``.
        blockchain: The current Blockchain object.
        mempool: The list of pending transactions.

    Returns:
        A dictionary indicating whether the share was accepted and
        whether it resulted in a new block.
    """
    # Reconstruct the data string used for hashing
    data_str = f"{work['index']}{work['previous_hash']}{work['transactions']}{nonce}"
    hash_result = hashlib.sha256(data_str.encode()).hexdigest()
    # Check if share meets pool difficulty
    if not hash_result.startswith(POOL_DIFFICULTY_PREFIX):
        return {'accepted': False, 'reason': 'Share does not meet pool difficulty'}
    # Record the share
    difficulty_score = len(POOL_DIFFICULTY_PREFIX)
    cur = _conn.cursor()
    cur.execute(
        "INSERT INTO shares (miner_id, share_hash, difficulty, timestamp) VALUES (?, ?, ?, ?)",
        (miner_id, hash_result, difficulty_score, datetime.utcnow().isoformat()),
    )
    # Increment the miner's share count
    cur.execute("UPDATE miners SET total_shares = total_shares + 1 WHERE miner_id = ?", (miner_id,))
    _conn.commit()
    # Determine if share also solves network difficulty for a full block
    network_target = '0' * DIFFICULTY
    new_block_mined = False
    if hash_result.startswith(network_target):
        # Use the mempool and blockchain to mine a real block and clear mempool
        block = mine_block(blockchain, MINER_ADDRESS, mempool)
        # Reset mempool is handled in mine_block
        new_block_mined = block is not None
    return {'accepted': True, 'hash': hash_result, 'block_mined': new_block_mined}


def pool_stats() -> Dict[str, Any]:
    """Return aggregate statistics about miners and shares."""
    cur = _conn.cursor()
    cur.execute("SELECT COUNT(*) FROM miners")
    num_miners = cur.fetchone()[0]
    cur.execute("SELECT COUNT(*) FROM shares")
    num_shares = cur.fetchone()[0]
    # Shares per miner
    cur.execute("SELECT miner_id, total_shares FROM miners")
    shares_per_miner = {row[0]: row[1] for row in cur.fetchall()}
    return {
        'num_miners': num_miners,
        'num_shares': num_shares,
        'shares_per_miner': shares_per_miner
    }