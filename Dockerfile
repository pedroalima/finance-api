FROM php:8.3-apache

# Dependências básicas
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Ativar o mod_rewrite do Apache (Laravel precisa)
RUN a2enmod rewrite

# Remover o arquivo de configuração padrão do Debian
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Pasta da aplicação
WORKDIR /var/www/html

# Copiar o arquivo de configuração de vhost customizado
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Ativar a nova configuração (embora geralmente já esteja ativada)
RUN a2ensite 000-default.conf

# Ajustar permissões para evitar erros de cache/log
RUN chown -R www-data:www-data /var/www/html
