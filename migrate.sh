#!/bin/bash
docker exec -it app_two bash -c "php artisan migrate:reset && php artisan migrate --seed"
