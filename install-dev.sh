#!/usr/bin/env bash
cp .env.example .env
cp src/Infrastructure/UI/Laravel/.env.example src/Infrastructure/UI/Laravel/.env
docker-compose up -d --build
docker exec -it pineapple_app composer install
docker exec -it pineapple_app php artisan key:generate
docker exec -it pineapple_server chown www-data src/Infrastructure/UI/Laravel/storage/ -R
docker exec -it pineapple_server chown www-data src/Infrastructure/UI/Laravel/bootstrap/ -R
docker exec -it pineapple_app ./vendor/bin/doctrine-migrations migrations:migrate --db-configuration=tests/Infrastructure/Persistence/Doctrine/MigrationTestConfig.php
