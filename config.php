<?php

// Router
define('URL_PREFIX', 'fruition');

// Database Connection

// // Server
// define('DATABASE_HOST', '192.168.12.1');
// define('DATABASE_PORT', '3306');
// define('DATABASE_USER', 'fruition_dev');
// define('DATABASE_PASS', 'lVERmetZEARAnlCULSHRa');
// define('DATABASE_NAME', 'fruition');

// Localhost
define('DATABASE_HOST', 'sdb-64.hosting.stackcp.net');
define('DATABASE_PORT', 'null');
define('DATABASE_USER', 'fruition');
define('DATABASE_PASS', 'Zne2V9e%T!JB');
define('DATABASE_NAME', 'fruition-35303337e6d1');

define('MAX_LOGIN_ATTEMPTS', 5);

// Autoload modules when used
spl_autoload_register(function ($class_name) {
    if (file_exists('modules/' . $class_name . '.php')) {
        require_once 'modules/' . $class_name . '.php';
    }
});
