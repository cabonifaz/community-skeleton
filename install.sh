#!/bin/bash
echo "Instalando UVdesk..."

# Instalar dependencias
composer install --no-dev --optimize-autoloader

# Configurar base de datos
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction

# Configurar assets
php bin/console assets:install
php bin/console uvdesk:configure-helpdesk --env=prod

echo "Instalación completada!"