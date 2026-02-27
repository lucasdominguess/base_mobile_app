# --- Estágio 1: Dependências (Composer) ---
FROM composer:2.7 AS vendor
WORKDIR /app

# Copia apenas os arquivos do composer para aproveitar o cache do Docker
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# Copia o resto do código e gera o autoloader otimizado
COPY . .
RUN composer dump-autoload --optimize

# --- Estágio 2: Runtime (Imagem final para a Render) ---
FROM php:8.4-fpm-alpine

# Instala Nginx, Supervisor e extensões PHP em um único comando para otimizar camadas
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-libs \
    postgresql-dev \
    icu-dev \
    libzip-dev \
    libpng-dev \
    bash \
    && docker-php-ext-install pdo_pgsql intl zip gd \
    && apk del postgresql-dev icu-dev libzip-dev libpng-dev # Remove pacotes de compilação para reduzir tamanho da imagem

WORKDIR /var/www

# Copia o código do projeto
COPY . .
# Copia a pasta vendor já montada do estágio 1
COPY --from=vendor /app/vendor/ ./vendor/

# Copia os arquivos de configuração
COPY ./docker/nginx.conf /etc/nginx/http.d/default.conf
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Ajusta permissões
RUN chmod +x /usr/local/bin/entrypoint.sh && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
