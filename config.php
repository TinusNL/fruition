<?php

// Router
// Production
define('URL_PREFIX', '.');

// Local
//define('URL_PREFIX', 'fruition');

// Database Connection
// Production
define('DATABASE_HOST', 'sdb-64.hosting.stackcp.net');
define('DATABASE_PORT', 'null');
define('DATABASE_USER', 'fruition');
define('DATABASE_PASS', 'Zne2V9e%T!JB');
define('DATABASE_NAME', 'fruition-35303337e6d1');

// Local
//define('DATABASE_HOST', 'localhost');
//define('DATABASE_PORT', '3306');
//define('DATABASE_USER', 'root');
//define('DATABASE_PASS', '1234');
//define('DATABASE_NAME', 'fruition');

define('MAX_LOGIN_ATTEMPTS', 5);
define('DELETED_USER_REMAINS', false);

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload modules when used
spl_autoload_register(function ($class_name) {
    if (file_exists('modules/' . $class_name . '.php')) {
        require_once 'modules/' . $class_name . '.php';
    }
});
