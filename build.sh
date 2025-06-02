#!/usr/bin/env bash

# Instala las dependencias de Laravel
composer install --no-dev --optimize-autoloader

# Copia el .env de ejemplo si no hay uno
if [ ! -f ".env" ]; then
  cp .env.example .env
fi

# Genera la APP_KEY
php artisan key:generate

# Ejecuta migraciones (puedes comentar esta línea si no quieres)
php artisan migrate --force
