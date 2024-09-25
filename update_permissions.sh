#!/bin/bash

# bash script to correct permissions and ownership of bootstrap/cache and storage
# change permissions for this file to run: chmod +x update_permissions.sh
# run as ./update_permissions.sh after composer update, composer install, getting error 500s

cd laravel
# Check if cd was successful
if [ $? -eq 0 ]; then
  echo "Successfully changed directory to $(pwd)"
else
  echo "Failed to change directory"
  exit 1
fi

sudo chown -R www-data:www-data bootstrap/cache
sudo chmod -R 775 bootstrap/cache

sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage


cd public
sudo chown www-data:www-data mix-manifest.json


#sudo find storage -type f -exec chmod 644 {} \;
#sudo find storage -type d -exec chmod 755 {} \;

