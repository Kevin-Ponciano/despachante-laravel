# Use a imagem oficial do PHP 8.2-FPM
FROM php:8.2-fpm

# Atualizar pacotes e instalar dependências
RUN apt-get update && apt-get install -y \
        libonig-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        libxml2-dev \
        zip \
        unzip \
        git \
        curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip opcache

# Instalar Node.js
RUN curl -sL https://deb.nodesource.com/setup_21.x -o nodesource_setup.sh \
    && chmod +x nodesource_setup.sh \
    && bash nodesource_setup.sh \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && rm -f nodesource_setup.sh

# Instalar Supervisor
RUN apt-get update && apt-get install -y supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copiar arquivos de configuração do Supervisor
# (Garanta que você tem um arquivo supervisord.conf adequado no seu projeto)
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar o código da aplicação para o diretório de trabalho
COPY . /var/www

# Copiar o arquivo .env da aplicação
COPY .env /var/www/.env

# Ajustar permissões dos diretórios do Laravel
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type f -exec chmod 644 {} \; \
    && find /var/www -type d -exec chmod 755 {} \; \
    && chmod -R 777 /var/www/storage \
    && chmod -R 777 /var/www/bootstrap/cache

# Instalar dependências do projeto
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Optimizar a aplicação Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

RUN npm install && npm run build

# Expor a porta 9000
EXPOSE 9000

# Comando padrão para iniciar o Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
