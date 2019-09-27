#!/bin/bash

composer install && npm install && php artisan migrate --seed && php artisan passport:install
