<?php

define('URL_PREFIX', 'fruition'); // Used in modules/Router.php

// Database Connection
define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');
define('DATABASE_NAME', 'fruition');

spl_autoload_register(function ($class_name) {
    if (file_exists('modules/' . $class_name . '.php')) {
        require_once 'modules/' . $class_name . '.php';
    }
});
