<?php

class Database
{
    public static $conn;

    public static function prepare($query)
    {
        $stmt = self::$conn->prepare($query);
        return $stmt;
    }
}

try {
    $dsn = "mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME;
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    );

    Database::$conn = new PDO($dsn, DATABASE_USER, DATABASE_PASS, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
