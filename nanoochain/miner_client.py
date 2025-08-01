#!/usr/bin/env python3
"""
Simple CLI miner client for the NanooChain mining pool.

This script communicates with the pool backend via HTTP.  It first
registers a miner (unless a miner ID is provided), then repeatedly
requests work and attempts to find a nonce whose hash meets the pool
difficulty.  When a valid share is found it submits the share to the
pool and prints the response.

Usage:

    python miner_client.py --server http://localhost:5000 --name alice

    # or use an existing miner ID
    python miner_client.py --server http://localhost:5000 --miner-id <uuid>

Note: This is a very basic miner intended for demonstration and
testing.  It does not implement multi‑threading or optimised
hashing loops and may run slowly.
"""

import argparse
import hashlib
import json
import random
import sys
import time
from typing import Optional

import requests


def register_miner(server: str, name: str) -> str:
    resp = requests.post(f"{server}/pool/register_miner", json={'name': name})
    resp.raise_for_status()
    data = resp.json()
    return data['miner_id']


def get_work(server: str) -> dict:
    resp = requests.get(f"{server}/pool/get_work")
    resp.raise_for_status()
    return resp.json()


def submit_share(server: str, miner_id: str, nonce: int) -> dict:
    resp = requests.post(f"{server}/pool/submit_share", json={'miner_id': miner_id, 'nonce': nonce})
    resp.raise_for_status()
    return resp.json()


def mine_once(work: dict, target_prefix: str) -> Optional[int]:
    """Attempt to find a valid nonce for the given work.

    Returns the nonce if found, otherwise None after exhausting the
    search space for one iteration.
    """
    for _ in range(100000):  # adjust iterations for performance
        nonce = random.randint(0, 2**32 - 1)
        data_str = f"{work['index']}{work['previous_hash']}{work['transactions']}{nonce}"
        h = hashlib.sha256(data_str.encode()).hexdigest()
        if h.startswith(target_prefix):
            return nonce
    return None


def main():
    parser = argparse.ArgumentParser(description='NanooChain CLI miner')
    parser.add_argument('--server', default='http://localhost:5000', help='Pool server URL')
    parser.add_argument('--name', help='Name to register as a new miner')
    parser.add_argument('--miner-id', help='Existing miner ID to resume mining')
    parser.add_argument('--once', action='store_true', help='Mine one share and exit')
    args = parser.parse_args()

    server = args.server.rstrip('/')
    miner_id = args.miner_id

    if not miner_id:
        if not args.name:
            print('You must provide --name when registering a new miner.', file=sys.stderr)
            sys.exit(1)
        print(f'Registering miner "{args.name}"...')
        miner_id = register_miner(server, args.name)
        print(f'Registered with miner ID: {miner_id}')

    print(f'Using miner ID: {miner_id}')

    try:
        while True:
            work = get_work(server)
            target_prefix = work['target_prefix']
            nonce = mine_once(work, target_prefix)
            if nonce is not None:
                result = submit_share(server, miner_id, nonce)
                print(f"Submitted nonce {nonce}, result: {json.dumps(result)}")
                if args.once:
                    break
            else:
                # No share found this iteration; wait briefly
                time.sleep(1)
            # small sleep to avoid overwhelming the server
            time.sleep(0.1)
            if args.once:
                break
    except KeyboardInterrupt:
        print('\nMining interrupted by user.')


if __name__ == '__main__':
    main()