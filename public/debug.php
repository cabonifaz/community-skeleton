<?php
echo "<h1>🚀 Debug UVdesk</h1>";
echo "<pre>";

// 1. Verificar PHP básico
echo "✅ PHP version: " . PHP_VERSION . "\n";

// 2. Verificar archivos
$files = [
    '../vendor/autoload.php',
    '../src/Kernel.php', 
    '../.env',
    '../config/bundles.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ $file - EXISTE\n";
    } else {
        echo "❌ $file - NO EXISTE\n";
    }
}

// 3. Verificar variables de entorno
echo "📝 Variables de entorno:\n";
echo "APP_ENV: " . ($_ENV['APP_ENV'] ?? 'NO DEFINIDO') . "\n";
echo "DATABASE_URL: " . (isset($_ENV['DATABASE_URL']) ? 'DEFINIDO' : 'NO DEFINIDO') . "\n";

// 4. Verificar base de datos
try {
    $pdo = new PDO('mysql:host=20.81.148.176;port=3306;dbname=uvdesk', 'root', 'WC39ka10@');
    echo "✅ MySQL - CONECTADO\n";
} catch (Exception $e) {
    echo "❌ MySQL Error: " . $e->getMessage() . "\n";
}

// 5. Verificar composer
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
    echo "✅ Composer - CARGADO\n";
}

echo "</pre>";
?>