#!/bin/bash

env=$1
host="dev.aa19e708-0df7-4489-8341-437b79509b9b@appserver.dev.aa19e708-0df7-4489-8341-437b79509b9b.drush.in"

echo "Deploying WordPress theme..."
rsync -rlvz --exclude 'plugins' --exclude '.git' --exclude '.gitignore' --ipv4 --delete-after --quiet -e 'ssh -p 2222  -o StrictHostKeyChecking=no' --temp-dir=../../../tmp/ $TRAVIS_BUILD_DIR $host:code/wp-content/themes
echo "Deploying WordPress plugins..."
rsync -rlvz --size-only --ipv4 --quiet -e 'ssh -p 2222  -o StrictHostKeyChecking=no' --temp-dir=../../tmp/ $TRAVIS_BUILD_DIR/plugins $host:code/wp-content/
