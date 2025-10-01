#!/bin/bash
set -e

echo "🚀 Iniciando UVdesk en Railway..."

# Configurar ServerName para Apache
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Detener MySQL local (no lo necesitamos)
echo "🛑 Deteniendo servicios locales no necesarios..."
service mysql stop || true

# Configurar permisos
echo "📁 Configurando permisos..."
chmod -R 755 var/ public/

# Verificar conexión a MySQL externo
echo "🔍 Verificando conexión a MySQL externo..."
if command -v mysql &> /dev/null; then
    mysql -h 20.81.148.176 -u root -pWC39ka10@ -e "SELECT 1;" && echo "✅ MySQL externo conectado" || echo "⚠️  No se pudo conectar a MySQL externo"
else
    echo "📦 Instalando mysql-client..."
    apt-get update && apt-get install -y mysql-client
fi

# Crear base de datos si no existe
echo "🗃️ Configurando base de datos..."
mysql -h 20.81.148.176 -u root -pWC39ka10@ -e "CREATE DATABASE IF NOT EXISTS uvdesk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" || true

# Ejecutar migraciones
echo "🔄 Ejecutando migraciones..."
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# Configurar UVdesk
echo "⚙️ Configurando UVdesk..."
php bin/console uvdesk:configure-helpdesk --env=prod

# Iniciar Apache
echo "🌐 Iniciando Apache..."
exec apache2-foreground