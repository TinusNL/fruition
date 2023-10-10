<?php
require_once 'config.php';

Router::loadPages('pages');
Router::loadUrl($_SERVER['REQUEST_URI']);
?>

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