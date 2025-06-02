# Imagen base de PHP con CLI
FROM php:8.2-cli

# Instalar dependencias del sistema y extensiones necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql zip gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar todos los archivos del proyecto al contenedor
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Copiar .env de ejemplo si no existe
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

# Generar clave de Laravel
RUN php artisan key:generate

# Ejecutar migraciones
RUN php artisan migrate --force

# Exponer el puerto que usará Laravel
EXPOSE 10000

# Comando que inicia Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
