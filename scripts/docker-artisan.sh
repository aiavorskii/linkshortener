#!/bin/bash
docker exec -t -u 1000:1000 linkshortener_app php artisan $@