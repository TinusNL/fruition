<?php
// Start Session
session_start();

require 'vendor/autoload.php';
require_once 'config.php';

Router::loadPages('pages');
Router::loadUrl($_SERVER['REQUEST_URI']);

// Check for tasks
Task::checkTasks();

// Check if tables exist
//Setup::setup();

// If the current page is not an api, load the header
if (Router::isApi()) {
    Router::getContent();
} else { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Fruition">
        <meta name="keywords" content="Fruition">
        <meta name="author" content="Plymouth City College & MBORijnland exchange project team">
        <link rel="apple-touch-icon" sizes="180x180" href="/<?= URL_PREFIX ?>/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/<?= URL_PREFIX ?>/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/<?= URL_PREFIX ?>/favicon-16x16.png">
        <link rel="manifest" href="/<?= URL_PREFIX ?>/site.webmanifest">
        <link rel="mask-icon" href="/<?= URL_PREFIX ?>/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="msapplication-TileImage" content="/<?= URL_PREFIX ?>/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./<?= Router::getOffset() ?>css/main.css">
        <title>Fruition</title>
    </head>

    <body>
        <?php

        Router::getContent();

        ?>
    </body>

    </html>
<?php } ?>