FROM php:8.3-apache

# Dependências básicas
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    nano \
    netcat-traditional \
    && docker-php-ext-install pdo pdo_mysql mysqli

# -----------------------------
# INSTALANDO O XDEBUG
# -----------------------------
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configuração do Xdebug
RUN echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug,develop" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini

# Ativar o mod_rewrite do Apache (Laravel precisa)
RUN a2enmod rewrite

# Remover o arquivo de configuração padrão do Debian
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Pasta da aplicação
WORKDIR /var/www/html

# Copiar o arquivo de configuração de vhost customizado
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Ativar a nova configuração
RUN a2ensite 000-default.conf

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html
