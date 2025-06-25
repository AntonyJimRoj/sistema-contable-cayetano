# Imagen base oficial con PHP y Composer
FROM php:8.2-apache

# Activar módulos requeridos y extensiones para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql zip gd

# Instalar Composer_2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto al contenedor
COPY . .

# Dar permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración personalizada de Apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Puerto de salida (Render recomienda usar 0.0.0.0:10000)
EXPOSE 80

# Comando para iniciar Laravel usando Apache
CMD ["apache2-foreground"]

# Instalar Composer
RUN composer install --no-dev --optimize-autoloader