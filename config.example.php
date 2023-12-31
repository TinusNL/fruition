<?php

// Router
define('URL_PREFIX', 'fruition');

// Database Connection
define('DATABASE_HOST', '127.0.0.1');
define('DATABASE_PORT', '3306');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');
define('DATABASE_NAME', 'fruition');

define('MAX_LOGIN_ATTEMPTS', 5);

// Autoload modules when used
spl_autoload_register(function ($class_name) {
    if (file_exists('modules/' . $class_name . '.php')) {
        require_once 'modules/' . $class_name . '.php';
    }
});
