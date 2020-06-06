#!/usr/bin/env bash
args=("$@")
docker exec -it pineapple_app ./vendor/bin/doctrine-migrations ${args[0]} --db-configuration=src/Infrastructure/Persistence/Doctrine/MigrationConfig.php --no-interaction
