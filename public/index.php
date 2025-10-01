<?php
// PUBLIC/INDEX.PHP - CON INSTALACIÓN AUTOMÁTICA

// 1. Configuración de errores
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

// 2. Variables de entorno para UVdesk
$requiredEnvVars = [
    'APP_ENV' => 'prod',
    'APP_DEBUG' => '1',
    'APP_SECRET' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6',
    'DATABASE_URL' => 'mysql://root:WC39ka10@@20.81.148.176:3306/uvdesk',
    'UV_SESSION_COOKIE_LIFETIME' => '3600',
    'UV_SESSION_COOKIE_SECURE' => 'auto',
    'UV_SESSION_COOKIE_SAMESITE' => 'lax',
    'UV_SUPPORT_EMAIL' => 'soporte@community-skeleton-production.up.railway.app',
    'UV_SITE_URL' => 'https://community-skeleton-production.up.railway.app',
    'UV_MAILER_URL' => 'null://localhost',
];

foreach ($requiredEnvVars as $key => $defaultValue) {
    if (!isset($_SERVER[$key]) && !isset($_ENV[$key])) {
        $_SERVER[$key] = $_ENV[$key] = $defaultValue;
    }
}

echo "🚀 Iniciando UVdesk...\n";

try {
    // 3. Cargar autoloader
    require_once dirname(__DIR__).'/vendor/autoload.php';
    echo "✅ Autoload cargado\n";

    // 4. VERIFICAR SI UVdesk ESTÁ INSTALADO
    // Intentar acceder a la base de datos para verificar instalación
    $connection = new PDO(
        'mysql:host=20.81.148.176;port=3306;dbname=uvdesk',
        'root',
        'WC39ka10@'
    );
    
    $tables = $connection->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) === 0) {
        echo "📦 UVdesk no instalado, ejecutando instalación...\n";
        
        // Ejecutar instalación
        $application = new Symfony\Component\Console\Application();
        $application->setAutoExit(false);
        
        // Configurar helpdesk
        $input = new Symfony\Component\Console\Input\ArrayInput([
            'command' => 'uvdesk:configure-helpdesk',
            '--env' => 'prod',
            '--no-interaction' => true,
        ]);
        
        $output = new Symfony\Component\Console\Output\BufferedOutput();
        $application->run($input, $output);
        echo $output->fetch();
        
        echo "✅ Instalación completada\n";
    } else {
        echo "✅ UVdesk ya instalado (" . count($tables) . " tablas)\n";
    }

    // 5. Crear y ejecutar kernel
    $kernel = new App\Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
    echo "✅ Kernel creado\n";
    
    // 6. Manejar la request
    $request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
    
} catch (Throwable $e) {
    echo "❌ ERROR:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    
    // Si es error de base de datos, mostrar ayuda específica
    if (strpos($e->getMessage(), 'SQLSTATE') !== false) {
        echo "\n💡 POSIBLE SOLUCIÓN:\n";
        echo "1. Verifica que la base de datos 'uvdesk' existe\n";
        echo "2. Ejecuta manualmente: php bin/console uvdesk:configure-helpdesk\n";
    }
    
    http_response_code(500);
}
?>