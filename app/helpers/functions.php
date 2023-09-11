<?php

function base_path($path = '')
{
    return realpath(__DIR__ . '/../..') . '/' . ltrim($path, '/');
}

function view($viewPath, array $data = [])
{
    // Extract data
    extract($data);
    // Convert the view path to a file path
    $viewFile = str_replace('/', DIRECTORY_SEPARATOR, $viewPath) . '.view.php';
    $viewFilePath = base_path("app/views/$viewFile");

    // Include the view file if it exists
    if (file_exists($viewFilePath)) {
        require $viewFilePath;
    } else {
        echo "View not found.";
        var_dump($viewFilePath);
    }
}