#!/bin/bash

# Make sure log folder exists
mkdir -p /opt/code/logs || true
# Install requirements
apt update && apt install -y jq
# Upgrade PIP
pip install -U pip
# Run Django migrations
python manage.py makemigrations
python manage.py migrate
# find defaults -name "*.json" -exec python manage.py loaddata {} \;
# Start Django server
python manage.py runserver 0.0.0.0:8000
