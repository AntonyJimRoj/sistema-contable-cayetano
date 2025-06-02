# Imagen base
FROM php:8.2-cli

# Instalar extensiones y librerías necesarias
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
    && docker-php-ext-install zip gd \
    && docker-php-ext-install pdo pdo_pgsql

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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

# Comando final
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]