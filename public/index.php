<?php
// PUBLIC/INDEX.PHP - CON INSTALACIÓN INCORPORADA

// Configuración
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Variables de entorno
$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = 'prod';
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = '1';
$_SERVER['APP_SECRET'] = $_ENV['APP_SECRET'] = 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6';
$_SERVER['DATABASE_URL'] = $_ENV['DATABASE_URL'] = 'mysql://root:WC39ka10@@20.81.148.176:3306/uvdesk';

try {
    require_once dirname(__DIR__).'/vendor/autoload.php';
    
    // VERIFICAR INSTALACIÓN ANTES DE CREAR KERNEL
    $connection = new PDO(
        'mysql:host=20.81.148.176;port=3306;dbname=uvdesk',
        'root',
        'WC39ka10@'
    );
    
    $tables = $connection->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "📦 UVdesk no instalado. Ejecutando instalación...<br>";
        
        // Ejecutar instalación via Symfony Console
        $application = new Symfony\Component\Console\Application();
        $application->setAutoExit(false);
        
        // Configurar helpdesk con respuestas automáticas
        $input = new Symfony\Component\Console\Input\ArrayInput([
            'command' => 'uvdesk:configure-helpdesk',
            '--env' => 'prod',
            '--no-interaction' => true,
        ]);
        
        $output = new Symfony\Component\Console\Output\BufferedOutput();
        $application->run($input, $output);
        echo nl2br($output->fetch());
        
        // Ejecutar migraciones
        $input = new Symfony\Component\Console\Input\ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction' => true,
            '--env' => 'prod',
        ]);
        
        $output = new Symfony\Component\Console\Output\BufferedOutput();
        $application->run($input, $output);
        echo nl2br($output->fetch());
        
        echo "✅ Instalación completada. <a href='/'>Recargar página</a><br>";
        exit;
    }
    
    // CONTINUAR CON APLICACIÓN NORMAL
    $kernel = new App\Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
    $request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
    
} catch (Throwable $e) {
    echo "<h1>Error UVdesk</h1>";
    echo "<p><strong>" . $e->getMessage() . "</strong></p>";
    echo "<pre>File: " . $e->getFile() . ":" . $e->getLine() . "</pre>";
    
    http_response_code(500);
}
?>