#!/bin/bash
set -e

# 1. Generate new SSH key without passphrase
ssh-keygen -t rsa -b 4096 -C "your_email@example.com" -f ~/.ssh/id_rsa -N ""

# 2. Start ssh-agent and add the new key
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_rsa

# 3. Show the public key (copy this to your GitHub SSH keys page)
echo "==== COPY THIS SSH PUBLIC KEY AND ADD TO GITHUB ===="
cat ~/.ssh/id_rsa.pub
echo "==================================================="

# 4. Test SSH connection to GitHub
ssh -T git@github.com || true

# 5. Change to your project directory
cd /opt/swaeduae

# 6. Set git remote to SSH URL
git remote set-url origin git@github.com:nanoochain/swaeduae.git

# 7. Add all changes, commit, and push to main branch
git add .
git commit -m "Sync all updates and fixes from VPS"
git push origin main

