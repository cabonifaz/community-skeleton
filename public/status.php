<?php
// Fuerza mostrar todo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔍 Estado de la Aplicación</h1>";
echo "<pre>";

// 1. Estado del servidor
echo "=== SERVER STATUS ===\n";
echo "PHP: " . PHP_VERSION . "\n";
echo "Memory: " . memory_get_usage() . "\n";
echo "Max Execution Time: " . ini_get('max_execution_time') . "\n";

// 2. Variables críticas
echo "\n=== ENV VARIABLES ===\n";
$critical_vars = ['APP_ENV', 'DATABASE_URL', 'APP_SECRET'];
foreach ($critical_vars as $var) {
    echo "$var: " . ($_ENV[$var] ?? 'NOT SET') . "\n";
}

// 3. Verificar UVdesk específicamente
echo "\n=== UVdesk FILES ===\n";
$uvdesk_files = [
    '../vendor/autoload.php',
    '../src/Kernel.php',
    '../config/bundles.php',
    '../config/packages/uvdesk.yaml',
    '../config/routes.yaml'
];

foreach ($uvdesk_files as $file) {
    echo $file . ": " . (file_exists($file) ? "EXISTS" : "MISSING") . "\n";
}

// 4. Probar Kernel
echo "\n=== KERNEL TEST ===\n";
try {
    require_once '../vendor/autoload.php';
    $kernel = new App\Kernel($_ENV['APP_ENV'] ?? 'prod', true);
    echo "✅ Kernel creado\n";
    
    // Test de rutas básicas
    $container = $kernel->getContainer();
    echo "✅ Container cargado\n";
} catch (Exception $e) {
    echo "❌ Kernel Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "</pre>";
?>