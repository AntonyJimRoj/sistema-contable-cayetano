# Imagen base PHP
FROM php:8.2-cli

# Instala extensiones y herramientas necesarias
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
    && docker-php-ext-install gd zip pdo pdo_pgsql

# Instalar Node.js y npm (para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Crear y movernos al directorio de la app
WORKDIR /app

# Copiar todos los archivos al contenedor
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias JS y compilar assets con Vite
RUN npm install && npm run build

# Copiar .env si no existe
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

# Generar APP_KEY
RUN php artisan key:generate

# ⚠️ IMPORTANTE: Enlazar storage y asegurarnos de que los assets estén disponibles
RUN php artisan storage:link \
 && ls -la public/build # 👈 Verifica que este directorio exista tras la compilación

# Exponer el puerto usado por Laravel
EXPOSE 10000

# Ejecutar migraciones y levantar el servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
