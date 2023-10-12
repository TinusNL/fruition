<?php
// Start Session
session_start();

require_once 'config.php';

Router::loadPages('pages');
Router::loadUrl($_SERVER['REQUEST_URI']);

// If the current page is not an api, load the header
if (Router::isApi()) {
    Router::getContent();
} else { ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fruition</title>
    <link rel="stylesheet" href="./<?= Router::getOffset() ?>css/main.css">
</head>

<body>
    <?php

    Router::getContent();

    ?>
</body>

</html>
<?php } ?>