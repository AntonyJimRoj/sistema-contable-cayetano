# Imagen base con PHP 8.2 y extensiones necesarias
FROM php:8.2-cli

# Instalar extensiones necesarias y Composer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar todos los archivos del proyecto al contenedor
COPY . .

# Instalar dependencias ANTES de ejecutar cualquier comando artisan
RUN composer install --no-dev --optimize-autoloader

# Copiar .env si no existe (por seguridad)
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

# Generar clave de aplicación
RUN php artisan key:generate

# Migrar base de datos
RUN php artisan migrate --force

# Exponer el puerto 10000
EXPOSE 10000

# Comando que inicia Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
