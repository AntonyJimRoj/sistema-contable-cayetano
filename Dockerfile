# Imagen base oficial con PHP, Composer, y extensiones necesarias
FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_pgsql zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar todos los archivos al contenedor
COPY . .

# Dar permisos de ejecución al build.sh
RUN chmod +x build.sh

# Ejecutar el script de instalación
RUN ./build.sh

# Exponer puerto para Laravel
EXPOSE 10000

# Comando de arranque
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
