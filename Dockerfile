# Usa una imagen base de PHP con Apache
FROM php:7.4-apache

# Instala extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli

# Copia el contenido de tu aplicación al directorio raíz de Apache
COPY . /var/www/html/

# Copia los scripts SQL al contenedor
COPY mysql/ /docker-entrypoint-initdb.d/

# Copia el contenido de tu aplicación al directorio raíz de Apache
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Da permisos al directorio de trabajo
RUN chown -R www-data:www-data /var/www/html

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite