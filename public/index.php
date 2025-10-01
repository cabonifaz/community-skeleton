<?php

// Cargar variables manualmente si no existen en Railway
if (!isset($_SERVER['APP_ENV'])) {
    $_SERVER['APP_ENV'] = 'prod';
    $_ENV['APP_ENV'] = 'prod';
}
if (!isset($_SERVER['APP_SECRET'])) {
    $_SERVER['APP_SECRET'] = 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6';
    $_ENV['APP_SECRET'] = 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6';
}
if (!isset($_SERVER['DATABASE_URL'])) {
    $_SERVER['DATABASE_URL'] = 'mysql://root:WC39ka10@@20.81.148.176:3306/uvdesk';
    $_ENV['DATABASE_URL'] = 'mysql://root:WC39ka10@@20.81.148.176:3306/uvdesk';
}

// Habilitar errores
error_reporting(E_ALL);
ini_set('display_errors', '1');

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};