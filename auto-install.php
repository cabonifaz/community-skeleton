<?php
// auto-install.php
require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

$application = new Application();
$application->setAutoExit(false);

// Comando para configurar UVdesk automáticamente
$input = new ArrayInput([
    'command' => 'uvdesk:configure-helpdesk',
    '--env' => 'prod',
    '--no-interaction' => true,
]);

$output = new BufferedOutput();
$application->run($input, $output);

echo $output->fetch();
echo "✅ UVdesk configurado automáticamente\n";
?>