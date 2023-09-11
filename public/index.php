<?php

use app\controllers\Router;

require_once '../app/helpers/functions.php';

spl_autoload_register(function ($className) {
    // Define the base directory for your classes
    $baseDir = __DIR__ . '/../';

    // Convert namespace separators to directory separators
    $className = str_replace('\\', '/', $className);

    // Build the full path to the class file
    $file = $baseDir . $className . '.php';

    // Include the class file if it exists
    if (file_exists($file)) {
        require_once $file;
    }
});

$router = new Router();

// Path to routes file
require_once base_path('app/routes/routes.php');

$router->handleRequest();
