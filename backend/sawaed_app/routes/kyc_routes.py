from flask import Blueprint, request, jsonify
from flask_jwt_extended import jwt_required, get_jwt_identity
from werkzeug.utils import secure_filename
from ..models import db, User, KYCSubmission
import os

kyc_bp = Blueprint('kyc', __name__)

UPLOAD_FOLDER = '/opt/swaeduae/backend/instance/uploads'
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

ALLOWED_EXTENSIONS = {'pdf', 'jpg', 'jpeg', 'png'}

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

@kyc_bp.route('/kyc/upload', methods=['POST'])
@jwt_required()
def upload_kyc():
    user_email = get_jwt_identity()
    user = User.query.filter_by(email=user_email).first()
    if not user:
        return jsonify({"msg": "User not found"}), 404

    if 'document' not in request.files:
        return jsonify({"msg": "No file part"}), 400
    file = request.files['document']
    if file.filename == '':
        return jsonify({"msg": "No selected file"}), 400
    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)
        file.save(filepath)

        # Save to DB
        kyc = KYCSubmission(user_id=user.id, document_url=filepath)
        db.session.add(kyc)
        db.session.commit()

        return jsonify({"msg": "KYC document uploaded", "kyc_id": kyc.id}), 201

    return jsonify({"msg": "File type not allowed"}), 400

@kyc_bp.route('/kyc/submissions', methods=['GET'])
@jwt_required()
def get_kyc_submissions():
    # Admin only route - implement your admin check logic here
    kyc_list = KYCSubmission.query.all()
    result = []
    for kyc in kyc_list:
        result.append({
            "id": kyc.id,
            "user_id": kyc.user_id,
            "document_url": kyc.document_url,
            "status": kyc.status,
            "submitted_at": kyc.submitted_at.isoformat()
        })
    return jsonify(result)

@kyc_bp.route('/kyc/approve/<int:kyc_id>', methods=['POST'])
@jwt_required()
def approve_kyc(kyc_id):
    # Admin only route - implement admin check
    kyc = KYCSubmission.query.get(kyc_id)
    if not kyc:
        return jsonify({"msg": "KYC submission not found"}), 404
    kyc.status = 'approved'
    db.session.commit()
    return jsonify({"msg": "KYC approved"})

@kyc_bp.route('/kyc/reject/<int:kyc_id>', methods=['POST'])
@jwt_required()
def reject_kyc(kyc_id):
    # Admin only route - implement admin check
    kyc = KYCSubmission.query.get(kyc_id)
    if not kyc:
        return jsonify({"msg": "KYC submission not found"}), 404
    kyc.status = 'rejected'
    db.session.commit()
    return jsonify({"msg": "KYC rejected"})

