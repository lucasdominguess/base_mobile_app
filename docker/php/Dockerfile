# Usa a imagem oficial do PHP 8.3 CLI (ideal para rodar o Laravel e comandos Artisan)
FROM php:8.3-cli

# Atualiza os pacotes e instala as dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    libpq-dev \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala as extensões essenciais do PHP para Laravel, Postgres e SQLite
RUN docker-php-ext-install pdo_pgsql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Instala o Composer diretamente da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho padrão dentro do container
WORKDIR /var/www

# Dá permissões de execução (opcional, mas recomendado para evitar problemas de permissão)
RUN chown -R www-data:www-data /var/www
