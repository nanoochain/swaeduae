# NanooChain Wallet utilities
#
# This module provides functions for generating wallets and signing
# transactions for the NanooChain project. It uses ECDSA keys on the
# secp256k1 curve for signing and verification. Addresses are derived
# from the public key by hashing it first with SHA‑256, then with
# RIPEMD‑160, and finally encoding the result using a custom base58
# alphabet. The address is prefixed with ``nanoo1`` to clearly
# identify NanooChain addresses.

import hashlib
import ecdsa
import json
from typing import Dict


# Base58 alphabet without 0,O,I,l characters to avoid ambiguity
_BASE58_ALPHABET = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz"


def _base58_encode(data: bytes) -> str:
    """Encode bytes into a base58 string.

    Leading zero bytes are encoded as the first character of the
    alphabet (which is '1') to preserve the same number of bytes when
    decoding. This implementation is adapted from the Bitcoin base58
    encoding algorithm.

    Args:
        data: The binary data to encode.

    Returns:
        A base58 encoded string.
    """
    # Convert the byte sequence to a big integer
    num = int.from_bytes(data, byteorder="big")
    encoded = ""
    # Perform division by 58 until the number is zero
    while num > 0:
        num, rem = divmod(num, 58)
        encoded = _BASE58_ALPHABET[rem] + encoded
    # Preserve leading zeros by prefixing with '1'
    prefix = ""
    for byte in data:
        if byte == 0:
            prefix += _BASE58_ALPHABET[0]
        else:
            break
    return prefix + encoded or _BASE58_ALPHABET[0]


def generate_wallet() -> Dict[str, str]:
    """Generate a new NanooChain wallet.

    A wallet consists of a private key, a public key and a base58
    encoded address. The address is derived by hashing the public
    key with SHA‑256, then RIPEMD‑160, and finally encoding using
    base58. It is prefixed with ``nanoo1``.

    Returns:
        A dictionary containing ``private_key``, ``public_key`` and
        ``address`` in hex/base58 string form.
    """
    # Generate a new ECDSA key pair on the secp256k1 curve
    signing_key = ecdsa.SigningKey.generate(curve=ecdsa.SECP256k1)
    verifying_key = signing_key.get_verifying_key()
    # Private key in hex for ease of storage/transmission
    private_key_hex = signing_key.to_string().hex()
    # Public key in hex (uncompressed)
    public_key_hex = verifying_key.to_string().hex()
    # Compute SHA‑256 then RIPEMD‑160 of the raw public key bytes
    sha_hash = hashlib.sha256(verifying_key.to_string()).digest()
    ripemd = hashlib.new("ripemd160")
    ripemd.update(sha_hash)
    hashed_pubkey = ripemd.digest()
    # Encode using base58 and add chain prefix
    address = "nanoo1" + _base58_encode(hashed_pubkey)
    return {
        "private_key": private_key_hex,
        "public_key": public_key_hex,
        "address": address,
    }


def sign_transaction(private_key_hex: str, tx_data: Dict) -> str:
    """Sign a transaction payload with the given private key.

    The transaction payload should be a dictionary containing the
    necessary fields such as sender, recipient and amount. The
    transaction is canonicalised into JSON with sorted keys before
    signing. The resulting signature is returned as a hex string.

    Args:
        private_key_hex: The private key as a hex string.
        tx_data: A dictionary representing the transaction payload.

    Returns:
        A hex string representing the signature.
    """
    sk = ecdsa.SigningKey.from_string(bytes.fromhex(private_key_hex), curve=ecdsa.SECP256k1)
    # Serialise the transaction deterministically
    message = json.dumps(tx_data, sort_keys=True).encode()
    signature_bytes = sk.sign(message)
    return signature_bytes.hex()


def verify_signature(public_key_hex: str, tx_data: Dict, signature_hex: str) -> bool:
    """Verify a transaction signature against the given public key.

    Args:
        public_key_hex: The public key in hex string format.
        tx_data: The original transaction payload as a dictionary.
        signature_hex: The signature in hex string format.

    Returns:
        ``True`` if the signature is valid, otherwise ``False``.
    """
    try:
        vk = ecdsa.VerifyingKey.from_string(bytes.fromhex(public_key_hex), curve=ecdsa.SECP256k1)
        message = json.dumps(tx_data, sort_keys=True).encode()
        vk.verify(bytes.fromhex(signature_hex), message)
        return True
    except Exception:
        return False


def address_from_public_key(public_key_hex: str) -> str:
    """Derive a NanooChain address from a public key.

    The public key should be provided as an uncompressed hex string.
    The address is calculated by hashing the raw public key bytes
    with SHA‑256, then RIPEMD‑160, then encoding using base58 and
    prefixing with ``nanoo1``. This mirrors the logic used in
    ``generate_wallet()`` and is exposed as a helper for deriving
    addresses from existing keys (e.g. for signing endpoints).

    Args:
        public_key_hex: The public key in hexadecimal form.

    Returns:
        A base58 encoded NanooChain address string.
    """
    pub_bytes = bytes.fromhex(public_key_hex)
    sha_hash = hashlib.sha256(pub_bytes).digest()
    ripemd = hashlib.new("ripemd160")
    ripemd.update(sha_hash)
    hashed_pubkey = ripemd.digest()
    return "nanoo1" + _base58_encode(hashed_pubkey)