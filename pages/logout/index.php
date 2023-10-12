<?php
// Destroy the session
session_destroy();

// Clear localStorage
echo '<script>localStorage.clear();</script>';

// Redirect to the homepage
header('Location: /' . URL_PREFIX . '/');