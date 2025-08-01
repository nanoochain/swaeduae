# NanooChain Transaction utilities
#
# Defines a simple Transaction class and helpers for validation.
# A transaction consists of a sender address, a recipient address,
# an amount and a signature. Transactions initiated by the network
# (e.g. block rewards) have ``sender`` set to ``"NETWORK"`` and are
# always considered valid.

from typing import Dict
from .wallet import verify_signature


class Transaction:
    """A representation of a transfer on the NanooChain."""

    def __init__(self, sender: str, recipient: str, amount: float, signature: str, public_key: str = None):
        self.sender = sender
        self.recipient = recipient
        self.amount = amount
        self.signature = signature
        # The public key used to verify the signature is optional for
        # transactions created by the network (e.g. mining rewards).
        self.public_key = public_key

    def to_dict(self) -> Dict:
        """Convert the transaction into a serialisable dictionary.

        The public key is not included since it is not needed when
        propagating transactions between nodes.
        """
        return {
            "sender": self.sender,
            "recipient": self.recipient,
            "amount": self.amount,
            "signature": self.signature,
        }


def is_valid_transaction(tx: Transaction) -> bool:
    """Validate a transaction.

    Mining reward transactions (sender == "NETWORK") are always valid.
    For regular transactions, the signature must be valid when
    verified against the provided public key and the transaction
    payload.  The transaction payload for signature purposes is
    reconstructed from the sender, recipient and amount fields.

    Args:
        tx: The ``Transaction`` instance to validate.

    Returns:
        ``True`` if valid, otherwise ``False``.
    """
    # Reward transactions are automatically valid
    if tx.sender == "NETWORK":
        return True
    # A public key is required to verify the signature
    if not tx.public_key:
        return False
    payload = {
        "sender": tx.sender,
        "recipient": tx.recipient,
        "amount": tx.amount,
    }
    return verify_signature(tx.public_key, payload, tx.signature)