#!/usr/bin/env bash
cp .env.example .env
docker-compose up -d --build
docker exec -it pineapple_app composer install

