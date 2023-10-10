<?php
// Destroy the session
session_destroy();

// Redirect to the homepage
header('Location: /' . URL_PREFIX . '/');