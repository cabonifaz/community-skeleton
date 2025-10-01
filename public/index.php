<?php
// PUBLIC/INDEX.PHP - VERSIÓN TEMPORAL SIMPLE

// Configuración básica
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

echo "<h1>🚀 UVdesk - Estado de la Instalación</h1>";
echo "<pre>";

// Verificar vendor
if (!file_exists('../vendor/autoload.php')) {
    echo "❌ ERROR: vendor/autoload.php no encontrado\n";
    echo "💡 SOLUCIÓN: Ejecuta 'composer install' primero\n";
    exit;
}

require_once '../vendor/autoload.php';

// Verificar comandos
try {
    $application = new Symfony\Component\Console\Application();
    
    // Listar comandos disponibles
    $commands = $application->all();
    $commandList = [];
    
    foreach ($commands as $name => $command) {
        $commandList[] = $name;
    }
    
    echo "Comandos disponibles (" . count($commandList) . "):\n";
    foreach ($commandList as $cmd) {
        echo "  - $cmd\n";
    }
    
    // Verificar comandos específicos
    $requiredCommands = ['uvdesk:configure-helpdesk', 'doctrine:migrations:migrate'];
    foreach ($requiredCommands as $cmd) {
        if (in_array($cmd, $commandList)) {
            echo "✅ $cmd - DISPONIBLE\n";
        } else {
            echo "❌ $cmd - NO DISPONIBLE\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n📝 Próximos pasos:\n";
echo "1. Visita /check-composer.php para diagnóstico completo\n";
echo "2. Si los comandos faltan, ejecuta 'composer install' manualmente\n";
echo "3. O visita /manual-setup.php para instalación manual\n";

echo "</pre>";
?>