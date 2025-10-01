<?php
// PUBLIC/INDEX.PHP - VERSIÓN CON VARIABLES UVdesk

// 1. Configuración de errores
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

// 2. Variables de entorno CRÍTICAS para UVdesk
$requiredEnvVars = [
    'APP_ENV' => 'prod',
    'APP_DEBUG' => '1',
    'APP_SECRET' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6',
    'DATABASE_URL' => 'mysql://root:WC39ka10@@20.81.148.176:3306/uvdesk',
    
    // Variables específicas de UVdesk
    'UV_SESSION_COOKIE_LIFETIME' => '3600',
    'UV_SESSION_COOKIE_SECURE' => 'auto',
    'UV_SESSION_COOKIE_SAMESITE' => 'lax',
    'UV_SUPPORT_EMAIL' => 'soporte@community-skeleton-production.up.railway.app',
    'UV_SITE_URL' => 'https://community-skeleton-production.up.railway.app',
    'UV_MAILER_URL' => 'null://localhost',
    'UV_DATABASE_HOST' => '20.81.148.176',
    'UV_DATABASE_PORT' => '3306',
    'UV_DATABASE_NAME' => 'uvdesk',
    'UV_DATABASE_USER' => 'root',
    'UV_DATABASE_PASSWORD' => 'WC39ka10@',
];

// 3. Establecer variables faltantes
foreach ($requiredEnvVars as $key => $defaultValue) {
    if (!isset($_SERVER[$key]) && !isset($_ENV[$key])) {
        $_SERVER[$key] = $_ENV[$key] = $defaultValue;
        echo "✅ Set $key: $defaultValue\n";
    } else {
        echo "✅ $key already set\n";
    }
}

echo "🚀 Iniciando UVdesk con todas las variables...\n";

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