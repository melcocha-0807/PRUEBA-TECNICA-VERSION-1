#!/bin/bash
cd /var/www/
EXIST=$($(ls "vendor" >> /dev/null 2>&1 && echo 1) || echo 0)
if [ $EXIST -eq 0 ]; then
    echo "Instalando dependencias (Composer)..."
    composer update --ignore-platform-reqs
    echo "Instalando dependencias (npm)..."
    npm install
    echo "Copiando environment..."
    cp .env.example .env
    php artisan key:generate
    echo "Configurando cache..."
    php artisan route:clear
    php artisan view:clear
    php artisan config:cache
fi
echo "Iniciando servidor de php..."
php artisan serve --host 0.0.0.0 --port 80