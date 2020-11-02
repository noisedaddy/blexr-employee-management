#!/usr/bin/env bash

# Composer install
composer install
composer update
npm install

#clear cache from spatie package
sudo php artisan cache:forget spatie.permission.cache && sudo php artisan cache:clear

# change permissions of storage and bootstrap folders. Do not use in production
sudo chmod -R 777 ../storage/
sudo chmod -R 777 ../bootstrap/

# Config and cache
php artisan optimize:clear
