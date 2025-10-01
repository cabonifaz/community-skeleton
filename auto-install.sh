#!/bin/bash

echo "🔧 Instalación automática de UVdesk..."

# Proporcionar respuestas automáticas al comando de instalación
{
  echo "uvdesk"       # Database name
  echo "root"         # Database user
  echo "WC39ka10@"    # Database password  
  echo "20.81.148.176" # Database host
  echo "3306"         # Database port
  echo "y"            # Confirm configuration
} | php bin/console uvdesk:configure-helpdesk --env=prod

# Verificar si la instalación fue exitosa
if [ $? -eq 0 ]; then
    echo "✅ UVdesk configurado correctamente"
else
    echo "⚠️  Reintentando con método alternativo..."
    # Método alternativo
    php bin/console uvdesk:configure-helpdesk --env=prod --no-interaction || true
fi

# Ejecutar migraciones de base de datos
echo "🗃️ Ejecutando migraciones..."
php bin/console doctrine:migrations:migrate --no-interaction --env=prod

echo "🚀 Iniciando servidor..."
php -S 0.0.0.0:8080 -t public public/index.php