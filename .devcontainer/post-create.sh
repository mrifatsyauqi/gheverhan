#!/bin/bash

composer install

npm install

cp -n .env.example .env

php artisan key:generate

touch database/database.sqlite

php artisan migrate --force