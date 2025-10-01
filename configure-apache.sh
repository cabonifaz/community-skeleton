#!/bin/bash

echo "🔧 Configurando Apache para Railway..."

# Configurar puerto desde variable de entorno
PORT=${PORT:-8080}
echo "Usando puerto: $PORT"

# Configurar Apache para el puerto correcto
cat > /etc/apache2/ports.conf << EOF
Listen $PORT
EOF

# Configurar virtual host
cat > /etc/apache2/sites-available/000-default.conf << EOF
<VirtualHost *:$PORT>
    DocumentRoot /workspace/public
    DirectoryIndex index.php

    <Directory /workspace/public>
        AllowOverride All
        Require all granted
        FallbackResource /index.php
    </Directory>

    ErrorLog /dev/stderr
    CustomLog /dev/stdout combined
</VirtualHost>
EOF

# Configurar ServerName
echo "ServerName localhost" >> /etc/apache2/apache2.conf

echo "✅ Apache configurado para puerto $PORT"