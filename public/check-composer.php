<?php
echo "<h1>🔍 Verificación de Composer</h1>";
echo "<pre>";

// Verificar vendor/autoload.php
if (file_exists('../vendor/autoload.php')) {
    echo "✅ vendor/autoload.php EXISTE\n";
    
    // Cargar autoloader
    require_once '../vendor/autoload.php';
    echo "✅ Autoloader cargado\n";
    
    // Verificar comandos disponibles
    $application = new Symfony\Component\Console\Application();
    $commands = $application->all();
    
    echo "Comandos disponibles:\n";
    foreach ($commands as $name => $command) {
        if (strpos($name, 'uvdesk') !== false || strpos($name, 'doctrine') !== false) {
            echo "  ✅ $name\n";
        }
    }
    
    // Verificar específicamente UVdesk
    if (class_exists('Webkul\UVDesk\CoreFrameworkBundle\UVDeskCoreFrameworkBundle')) {
        echo "✅ UVdesk bundles cargados\n";
    } else {
        echo "❌ UVdesk bundles NO cargados\n";
    }
    
} else {
    echo "❌ vendor/autoload.php NO EXISTE\n";
    echo "📁 Directorio vendor: " . (is_dir('../vendor') ? 'EXISTE' : 'NO EXISTE') . "\n";
}

echo "</pre>";
?>