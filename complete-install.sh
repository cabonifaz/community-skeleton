#!/bin/bash

echo "🚀 Completando instalación de UVdesk..."

# Configurar la base de datos automáticamente
php bin/console uvdesk:configure-helpdesk --env=prod << EOF
uvdesk
root
WC39ka10@
20.81.148.176
3306
y
EOF

echo "✅ Instalación completada"

# Iniciar servidor
php -S 0.0.0.0:8080 -t public