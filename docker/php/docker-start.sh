#!/bin/bash

php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear

php artisan migrate --force
# php artisan db:seed --force

#php artisan serve --host 0.0.0.0 --port 9000

php -S 0.0.0.0:9000 -t public

