<?php

class Database
{
    public static PDO $conn;

    public static function prepare($query): bool|PDOStatement
    {
        return self::$conn->prepare($query);
    }

    public function lastInsertId(): bool|string
    {
        return self::$conn->lastInsertId();
    }
}

try {
    if (DATABASE_PORT == 'null') {
        $dsn = "mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME;
    }
    else {
        $dsn = "mysql:host=" . DATABASE_HOST . ";port=" . DATABASE_PORT . ";dbname=" . DATABASE_NAME;
    }

    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    );

    Database::$conn = new PDO($dsn, DATABASE_USER, DATABASE_PASS, $options);
} catch (PDOException $e) {
    // Redirect to error page
    header('Location: /' . URL_PREFIX . '/error?details=' . $e->getCode());
}
