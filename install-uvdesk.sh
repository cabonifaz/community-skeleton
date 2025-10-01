#!/bin/bash

echo "🔧 Instalando UVdesk..."

# Esperar a que MySQL esté listo
sleep 5

# Configurar UVdesk automáticamente
{
  echo "uvdesk"       # Database name
  echo "root"         # Database user  
  echo "WC39ka10@"    # Database password
  echo "20.81.148.176" # Database host
  echo "3306"         # Database port
  echo "y"            # Confirm
} | php bin/console uvdesk:configure-helpdesk --env=prod

# Verificar si la instalación fue exitosa
if [ $? -eq 0 ]; then
    echo "✅ UVdesk instalado correctamente"
    echo "🚀 Iniciando servidor..."
    php -S 0.0.0.0:8080 -t public
else
    echo "❌ Error en la instalación"
    # Intentar modo manual
    php bin/console uvdesk:configure-helpdesk --env=prod --no-interaction || true
    php -S 0.0.0.0:8080 -t public
fi