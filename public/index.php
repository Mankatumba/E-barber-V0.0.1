<?php
session_start();

require_once __DIR__ . '/../src/config/constants.php';
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/core/Router.php';
require_once __DIR__ . '/../src/helpers/Auth.php';

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../src/controllers/' . $class . '.php',
        __DIR__ . '/../src/models/' . $class . '.php',
        __DIR__ . '/../src/core/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$url = $_GET['url'] ?? '';
$router = new Router($url);
$router->dispatch();
