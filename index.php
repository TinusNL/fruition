<?php
spl_autoload_register(function ($class_name) {
    if (file_exists('modules/' . $class_name . '.php')) {
        require_once 'modules/' . $class_name . '.php';
    }
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fruition</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <?php include 'components/header.php' ?>
    <?php

    Router::addPages('pages/*');
    Router::getPageByUrl($_SERVER['REQUEST_URI']);


    ?>
</body>

</html>