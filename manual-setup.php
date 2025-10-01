<?php
// manual-setup.php - Instalación manual
echo "<h1>🔧 Instalación Manual UVdesk</h1>";
echo "<pre>";

// 1. Verificar composer
if (!file_exists('vendor/autoload.php')) {
    echo "❌ Composer no instalado. Ejecuta: composer install\n";
    exit;
}

require_once 'vendor/autoload.php';

// 2. Verificar bundles
$bundles = [
    'Webkul\UVDesk\CoreFrameworkBundle\UVDeskCoreFrameworkBundle',
    'Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle',
    'Symfony\Bundle\FrameworkBundle\FrameworkBundle',
];

foreach ($bundles as $bundle) {
    if (class_exists($bundle)) {
        echo "✅ $bundle\n";
    } else {
        echo "❌ $bundle - NO ENCONTRADO\n";
    }
}

// 3. Configurar base de datos manualmente
echo "\n🗃️ Configurando base de datos...\n";
try {
    $pdo = new PDO(
        'mysql:host=20.81.148.176;port=3306',
        'root',
        'WC39ka10@'
    );
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS uvdesk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Base de datos creada\n";
    
    // Crear tablas manualmente (ejemplo básico)
    $pdo = new PDO(
        'mysql:host=20.81.148.176;port=3306;dbname=uvdesk',
        'root',
        'WC39ka10@'
    );
    
    // Tabla de usuarios básica
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS uv_user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(180) NOT NULL,
            password VARCHAR(255) NOT NULL,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    
    echo "✅ Tablas básicas creadas\n";
    
} catch (Exception $e) {
    echo "❌ Error base de datos: " . $e->getMessage() . "\n";
}

echo "\n🎉 Configuración manual completada\n";
echo "</pre>";
?>