#!/bin/bash
/code/docker/php/wait-for-it.sh database:3306 -t 60
php /code/artisan migrate
php /code/artisan db:seed
php /code/artisan swagger-lume:generate
docker-php-entrypoint php-fpm