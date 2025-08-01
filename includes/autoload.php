<?php
spl_autoload_register(function ($class) {
    // Namespace prefix
    $prefix = 'Haskris\\';

    // Base directory for the namespace prefix
    $baseDir = __DIR__ . '/../mvc/';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Not in our namespace
    }

    // Get the class name after removing the namespace prefix
    $relativeClass = substr($class, $len);

    // Split into parts
    $parts = explode('\\', $relativeClass);

    // Extract the class name (filename)
    $className = array_pop($parts); // e.g., OrderController

    // Lowercase the folders only
    $folders = array_map('strtolower', $parts);

    // Construct the full path
    $filePath = $baseDir . implode('/', $folders) . '/' . $className . '.php';

    // Load if file exists
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});
