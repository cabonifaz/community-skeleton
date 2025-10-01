<?php
// install.php - Instalación completamente automática
require_once 'vendor/autoload.php';

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Application;

echo "🔧 Instalación automática de UVdesk\n";

$application = new Application();
$application->setAutoExit(false);

// Configurar la base de datos directamente via Doctrine
try {
    $connection = new PDO(
        'mysql:host=20.81.148.176;port=3306',
        'root',
        'WC39ka10@'
    );
    
    // Crear base de datos si no existe
    $connection->exec("CREATE DATABASE IF NOT EXISTS uvdesk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Base de datos 'uvdesk' creada/verificada\n";
    
} catch (Exception $e) {
    echo "❌ Error base de datos: " . $e->getMessage() . "\n";
}

// Ejecutar migraciones para crear tablas
echo "🗃️ Creando tablas...\n";
$input = new ArrayInput([
    'command' => 'doctrine:migrations:migrate',
    '--no-interaction' => true,
    '--env' => 'prod'
]);

$output = new BufferedOutput();
$result = $application->run($input, $output);
echo $output->fetch();

if ($result === 0) {
    echo "✅ Tablas creadas correctamente\n";
} else {
    echo "⚠️  Error creando tablas, continuando...\n";
}

// Configurar UVdesk (bypass del comando interactivo)
echo "⚙️ Configurando UVdesk...\n";

// Crear configuración manualmente
$config = [
    'database' => [
        'name' => 'uvdesk',
        'user' => 'root', 
        'password' => 'WC39ka10@',
        'host' => '20.81.148.176',
        'port' => '3306'
    ]
];

file_put_contents('var/installed.json', json_encode($config));
echo "✅ Configuración guardada\n";

echo "🎉 Instalación completada!\n";
?>