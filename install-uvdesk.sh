<?php
// install-uvdesk.php
require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

echo "🔧 Instalando UVdesk...\n";

$application = new Application();
$application->setAutoExit(false);

// 1. Configurar helpdesk
$input = new ArrayInput([
    'command' => 'uvdesk:configure-helpdesk',
    '--env' => 'prod',
    '--no-interaction' => true,
]);

$output = new BufferedOutput();
$result = $application->run($input, $output);

echo $output->fetch();
echo "✅ Configuración completada (Código: $result)\n";

// 2. Ejecutar migraciones de base de datos
$input = new ArrayInput([
    'command' => 'doctrine:migrations:migrate',
    '--env' => 'prod',
    '--no-interaction' => true,
]);

$output = new BufferedOutput();
$result = $application->run($input, $output);

echo $output->fetch();
echo "✅ Migraciones completadas (Código: $result)\n";

echo "🎉 UVdesk instalado correctamente\n";
?>