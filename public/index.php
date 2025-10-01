<?php
// PUBLIC/INDEX.PHP - VERSIÓN CORREGIDA

// 1. Configuración de errores MÁXIMA
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 2. Headers para debug
header('Content-Type: text/plain; charset=utf-8');

// 3. Variables de entorno FIJAS para desarrollo
$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'prod';
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? '1';
$_SERVER['APP_SECRET'] = $_ENV['APP_SECRET'] = $_SERVER['APP_SECRET'] ?? $_ENV['APP_SECRET'] ?? 'dev_secret_123456789';
$_SERVER['DATABASE_URL'] = $_ENV['DATABASE_URL'] = $_SERVER['DATABASE_URL'] ?? $_ENV['DATABASE_URL'] ?? 'mysql://root:WC39ka10@@20.81.148.176:3306/uvdesk';

echo "🚀 Iniciando UVdesk...\n";
echo "APP_ENV: " . $_ENV['APP_ENV'] . "\n";
echo "DATABASE_URL: " . ($_ENV['DATABASE_URL'] ? 'SET' : 'NOT SET') . "\n";

try {
    // 4. Cargar autoloader
    if (!file_exists(dirname(__DIR__).'/vendor/autoload.php')) {
        throw new RuntimeException('Vendor autoload no encontrado.');
    }
    
    require_once dirname(__DIR__).'/vendor/autoload.php';
    echo "✅ Autoload cargado\n";

    // 5. Crear y ejecutar kernel
    $kernel = new App\Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
    echo "✅ Kernel creado\n";
    
    // 6. Manejar la request
    $request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
    
} catch (Throwable $e) {
    echo "❌ ERROR CRÍTICO:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
    http_response_code(500);
}
?>