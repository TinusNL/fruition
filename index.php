<?php
// Start Session
session_start();

require_once 'config.php';

Router::loadPages('pages');
Router::loadUrl($_SERVER['REQUEST_URI']);

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