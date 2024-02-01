# Use a imagem oficial do PHP com Apache, versão buster para ser mais leve
FROM php:8.2-apache-buster

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        curl \
        nano \
        libpq-dev \
        supervisor
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip opcache pdo_pgsql pgsql

RUN pecl install zip && docker-php-ext-enable zip \
    && pecl install igbinary && docker-php-ext-enable igbinary \
    && yes | pecl install redis && docker-php-ext-enable redis

# setup node js source will be used later to install node js
RUN curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh
RUN ["sh",  "./nodesource_setup.sh"]

# Configurar o Apache para servir o diretório público do Laravel
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/public\n\
    <Directory /var/www/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite para o Apache
RUN a2enmod rewrite

# Configurações recomendadas para o Opcache para melhorar o desempenho do PHP
RUN { \
        echo 'opcache.memory_consumption=256'; \
        echo 'opcache.interned_strings_buffer=16'; \
        echo 'opcache.max_accelerated_files=7963'; \
        echo 'opcache.revalidate_freq=2'; \
        echo 'opcache.fast_shutdown=1'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Definir diretório de trabalho para /var/www (pasta padrão do Apache)
WORKDIR /var/www

# Copiar o código da aplicação para o diretório de trabalho
COPY . /var/www

# Copiar o env da aplicação
COPY .env /var/www/.env


# Ajustar permissões dos diretórios do Laravel
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type f -exec chmod 644 {} \; \
    && find /var/www -type d -exec chmod 755 {} \; \
    && chmod -R 777 /var/www/storage \
    && chmod -R 777 /var/www/bootstrap/cache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Optimizar a aplicação Laravel
RUN php artisan otpimize

# Instalar Node.js
RUN npm install \
    && npm run build \

RUN apache2-foreground

# Expor a porta 80
EXPOSE 80

# Copiar o script de entrada para o container
# COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Copiar o arquivo de configuração do Supervisor para o container
COPY docker/supervisord.conf /etc/supervisord.conf
RUN chmod +x /etc/supervisord.conf
# run supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]


# Dar permissões de execução ao script de entrada
#RUN chmod +x /usr/local/bin/entrypoint.sh

# Definir o script de entrada como ponto de entrada padrão do container
# ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Especificar o comando padrão a ser executado pelo entrypoint
# CMD ["apache2-foreground"]
