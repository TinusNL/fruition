<?php

use JetBrains\PhpStorm\NoReturn;

class User
{
    public static function findUserByEmail(string $email): bool
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function login(string $email, string $password)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    #[NoReturn] public static function createUserSession($loggedInUser): void
    {
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['user_email'] = $loggedInUser['email'];
        $_SESSION['user_username'] = $loggedInUser['username'];
        header('Location: /' . URL_PREFIX . '/');
        exit();
    }

    public static function register(array $data): bool
    {
        $default_role = 1;
        $query = "INSERT INTO users (email, username, password, roleId) VALUES (:email, :username, :password, :roleId)";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':roleId', $default_role);
        $stmt->execute();

        return true;
    }
}
