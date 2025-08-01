# Mining utilities for NanooChain.

import hashlib
from typing import List, Dict, Optional

from .blockchain import Block, Blockchain
from .config import DIFFICULTY, MINING_REWARD


def proof_of_work(block: Block) -> str:
    """Simple proof of work algorithm.

    Increment the block's nonce until its hash starts with DIFFICULTY
    number of zeros. Returns the resulting hash.
    """
    block.nonce = 0
    computed_hash = block.compute_hash()
    # Continue incrementing the nonce until the hash matches the target
    target_prefix = "0" * DIFFICULTY
    while not computed_hash.startswith(target_prefix):
        block.nonce += 1
        computed_hash = block.compute_hash()
    return computed_hash


def mine_block(blockchain: Blockchain, miner_address: str, mempool: List[Dict]) -> Optional[Block]:
    """Mine a new block with transactions from the mempool and a reward.

    Args:
        blockchain: The blockchain to append the new block to.
        miner_address: The address receiving the mining reward.
        mempool: List of pending transactions; will be cleared on success.

    Returns:
        The mined Block if successful, otherwise ``None``.
    """
    if not mempool:
        return None

    # Create reward transaction. It does not require a signature or public key
    reward_tx = {
        "sender": "NETWORK",
        "recipient": miner_address,
        "amount": MINING_REWARD,
    }
    # Combine pending transactions with the reward transaction
    transactions = mempool[:] + [reward_tx]
    last_block = blockchain.chain[-1]
    new_block = Block(
        index=last_block.index + 1,
        transactions=transactions,
        previous_hash=last_block.compute_hash(),
    )
    # Solve proof of work
    new_block.hash = proof_of_work(new_block)
    # Append to chain and clear mempool on success
    if blockchain.add_block(new_block):
        mempool.clear()
        return new_block
    return None