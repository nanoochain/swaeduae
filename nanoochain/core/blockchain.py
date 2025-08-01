# Basic blockchain implementation for NanooChain.
#
# The ``Blockchain`` class manages a simple chain of blocks stored on
# disk. Each block contains an index, timestamp, list of
# transactions, previous block hash and a nonce. The chain can be
# loaded from and saved to a JSON file in the ``data`` directory.

import time
import json
import os
import hashlib
from typing import List, Dict


# Path where the blockchain is persisted. In production this could
# point to a database or more sophisticated storage backend.
CHAIN_FILE = "data/chain.json"


class Block:
    """Represents a single block in the blockchain."""

    def __init__(self, index: int, transactions: List[Dict], previous_hash: str, nonce: int = 0, timestamp: float = None):
        self.index = index
        self.timestamp = timestamp or time.time()
        self.transactions = transactions
        self.previous_hash = previous_hash
        self.nonce = nonce
        # Hash will be filled in once proof of work is complete
        self.hash: str | None = None

    def compute_hash(self) -> str:
        """Compute the SHA‑256 hash of the block's contents (excluding hash)."""
        block_string = json.dumps({
            "index": self.index,
            "timestamp": self.timestamp,
            "transactions": self.transactions,
            "previous_hash": self.previous_hash,
            "nonce": self.nonce,
        }, sort_keys=True)
        return hashlib.sha256(block_string.encode()).hexdigest()


class Blockchain:
    """A persistent list of blocks forming the ledger."""

    def __init__(self):
        self.chain: List[Block] = []
        self.load_chain()

    def create_genesis_block(self) -> None:
        """Create the first block in the chain and persist it."""
        genesis_block = Block(0, [], "0")
        genesis_block.hash = genesis_block.compute_hash()
        self.chain.append(genesis_block)
        self.save_chain()

    def load_chain(self) -> None:
        """Load the chain from disk or create a genesis block if none exists."""
        if os.path.exists(CHAIN_FILE):
            with open(CHAIN_FILE, "r") as f:
                data = json.load(f)
                for block_data in data:
                    block = Block(
                        index=block_data["index"],
                        transactions=block_data["transactions"],
                        previous_hash=block_data["previous_hash"],
                        nonce=block_data["nonce"],
                        timestamp=block_data["timestamp"],
                    )
                    block.hash = block_data.get("hash")
                    self.chain.append(block)
        else:
            self.create_genesis_block()

    def save_chain(self) -> None:
        """Persist the chain to disk as JSON."""
        with open(CHAIN_FILE, "w") as f:
            json.dump([
                {
                    "index": b.index,
                    "timestamp": b.timestamp,
                    "transactions": b.transactions,
                    "previous_hash": b.previous_hash,
                    "nonce": b.nonce,
                    "hash": b.hash,
                }
                for b in self.chain
            ], f, indent=4)

    def add_block(self, block: Block) -> bool:
        """Append a block to the chain if it references the current last block."""
        if self.chain and self.chain[-1].compute_hash() == block.previous_hash:
            self.chain.append(block)
            self.save_chain()
            return True
        # Empty chain should only accept genesis block
        if not self.chain and block.previous_hash == "0":
            self.chain.append(block)
            self.save_chain()
            return True
        return False

    def get_balance(self, address: str) -> float:
        """Calculate the balance for a given address over the entire chain."""
        balance = 0.0
        for block in self.chain:
            for tx in block.transactions:
                # Reward transactions may not include a signature/public key
                sender = tx.get('sender')
                recipient = tx.get('recipient')
                amount = tx.get('amount', 0)
                if recipient == address:
                    balance += amount
                if sender == address:
                    balance -= amount
        return balance