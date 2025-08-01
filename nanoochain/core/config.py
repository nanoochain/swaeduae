# Configuration for NanooChain core components.

import os

# Default port the node listens on
PORT: int = int(os.getenv("PORT", 5000))

# Address that receives mining rewards; override with MINER_ADDRESS env var
MINER_ADDRESS: str = os.getenv("MINER_ADDRESS", "nanoo1defaultmineraddress")

# Mining difficulty (number of leading zeros required in block hash)
DIFFICULTY: int = 3

# Reward for mining a block
MINING_REWARD: float = 50

# ---------------------------------------------------------------------------
# Pool and authentication settings
# ---------------------------------------------------------------------------

# Secret key used for signing JWT tokens and generating TOTP codes. In a
# production environment this should be set via an environment variable and
# kept secret.
SECRET_KEY: str = os.getenv("NANOOCHAIN_SECRET", "nanoo_secret_key_change_me")

# Number of leading hex zeros required for a share to be considered valid
# by the mining pool.  This allows the pool to award partial credit
# without miners necessarily solving the full network difficulty. A
# smaller number of zeros yields easier shares.
POOL_DIFFICULTY_PREFIX: str = os.getenv("POOL_DIFFICULTY_PREFIX", "0000")

# Location of the SQLite database used by the pool and auth subsystems.
DATA_DIR: str = os.getenv("DATA_DIR", "data")
POOL_DB_PATH: str = os.path.join(DATA_DIR, "pool.db")
AUTH_DB_PATH: str = os.path.join(DATA_DIR, "auth.db")