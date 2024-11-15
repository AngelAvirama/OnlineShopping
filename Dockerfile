# Usa la imagen de PHP con Apache
FROM php:8.1-apache

# Copia los archivos del proyecto al directorio raíz de Apache
COPY . /var/www/html

# Instala extensiones necesarias de PHP para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configura permisos para Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80 para el servidor web
EXPOSE 80
