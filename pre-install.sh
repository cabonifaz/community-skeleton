#!/bin/bash

echo "🔧 Pre-instalación UVdesk"

# Crear estructura de directorios
mkdir -p var/cache var/log
chmod -R 755 var/ public/

# Configurar cache
php bin/console cache:clear --no-warmup --env=prod || true

echo "✅ Pre-instalación completada"