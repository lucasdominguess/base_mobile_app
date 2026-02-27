#!/bin/bash
set -e

echo "Gerando cache de produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Rodando migrations do banco de dados..."
php artisan migrate --force

echo "Iniciando serviços via Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
