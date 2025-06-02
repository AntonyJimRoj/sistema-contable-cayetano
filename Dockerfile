FROM php:8.2-cli

# Instala extensiones del sistema necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Habilita extensiones de PHP requeridas
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Crea directorio de trabajo
WORKDIR /app

# Copia archivos del proyecto
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Copia .env si no existe
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

# Genera clave de aplicación
RUN php artisan key:generate

# 👉 IMPORTANTE: quitamos la migración automática (la moveremos al inicio del contenedor)
# RUN php artisan migrate --force

# Exponemos el puerto 10000
EXPOSE 10000

# Comando de arranque: Laravel + migraciones
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
