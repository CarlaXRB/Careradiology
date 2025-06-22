# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar todos los archivos del proyecto
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Dar permisos a Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Generar APP_KEY automáticamente (opcional, solo si no se pasa como variable)
# RUN php artisan key:generate

# Configurar Apache para servir desde /public
RUN echo "DocumentRoot /var/www/html/public" > /etc/apache2/sites-enabled/000-default.conf

# Exponer el puerto
EXPOSE 80

# Comando de inicio del contenedor
CMD ["apache2-foreground"]
