<?php
$error = $_GET['details'] ?? 'A0000';
$error = strtoupper($error);
?>

<div class="error_main">
    <div class="error_left">
        <p class="error">Whoops!</p>
        <p class="error_msg"> <?= $error ?> </p>
        <p class="error_msg">Something went wrong, please contact the administrator.</p>
        <a class="go_back" href="/<?= URL_PREFIX ?>/">Go back</a>
    </div>
    <div class="logo_error">
        <img src="./assets/logo.svg" alt="logo">
    </div>

    <!-- Email -->
    <p class="email">Email: <a href="mailto:technical@fruition.city">technical@fruition.city</a></p>
</div>