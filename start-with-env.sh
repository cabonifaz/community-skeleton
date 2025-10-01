#!/bin/bash

# Cargar variables manualmente si no existen
export APP_ENV=${APP_ENV:-prod}
export APP_SECRET=${APP_SECRET:-a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6}
export DATABASE_URL=${DATABASE_URL:-"mysql://root:WC39ka10@@20.81.148.176:3306/uvdesk"}

echo "🔧 Variables cargadas:"
echo "APP_ENV: $APP_ENV"
echo "DATABASE_URL: $DATABASE_URL"

# Configurar UVdesk
php bin/console uvdesk:configure-helpdesk --env=$APP_ENV

# Iniciar servidor
echo "🚀 Iniciando servidor..."
php -S 0.0.0.0:8080 -t public