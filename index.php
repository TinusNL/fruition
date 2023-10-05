<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fruition</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <?php

    Router::addPages('pages');
    Router::getPageByUrl($_SERVER['REQUEST_URI']);

    ?>
</body>

</html>