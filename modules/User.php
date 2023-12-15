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

    public static function createUserSession($loggedInUser): void
    {
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['user_email'] = $loggedInUser['email'];
        $_SESSION['user_username'] = $loggedInUser['username'];
        header('Location: /' . URL_PREFIX . '/');
        exit();
    }

    public static function register(array $data): bool
    {
        $default_role = 2;
        $query = "INSERT INTO users (email, username, password, role) VALUES (:email, :username, :password, :role)";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':role', $default_role);

        return $stmt->execute();
    }

    public static function addFailedAttempt(string $ip_address): void
    {
        // Get current attempts
        $orig_attempts = self::getFailedAttempts($ip_address);
        $entry_existed = self::getEntry($ip_address);

        if (!$entry_existed) {
            $new_attempts = 1;
            self::insertFailedAttempt($ip_address, $new_attempts);
        } else {
            // Update the attempts
            $new_attempts = $orig_attempts + 1;
            self::updateFailedAttempt($ip_address, $new_attempts);
        }
    }

    public static function getFailedAttempts(string $ip_address)
    {
        $query = "SELECT * FROM `failed_login_attempts` WHERE `ip_addr` = :ip_address";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['attempts'] ?? null;
    }

    private static function insertFailedAttempt(string $ip_address, int $new_attempts): void
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO `failed_login_attempts` (`ip_addr`, `attempts`, `last_attempt`) VALUES (:ip_address, :attempts, :last_attempt)";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->bindParam(':attempts', $new_attempts);
        $stmt->bindParam(':last_attempt', $date);
        $stmt->execute();
    }

    private static function updateFailedAttempt(string $ip_address, int $new_attempts): void
    {
        $query = "UPDATE `failed_login_attempts` SET `attempts` = :attempts WHERE `ip_addr` = :ip_address";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':attempts', $new_attempts);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->execute();
    }

    public static function checkLastAttempt(string $ip_address): bool
    {
        $query = "SELECT * FROM `failed_login_attempts` WHERE `ip_addr` = :ip_address";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $last_attempt = strtotime($result['last_attempt']);

        if (!$last_attempt) {
            return false;
        }

        // Check if the last attempt was more than 5 minutes ago
        $time_diff = $last_attempt - time();
        if ($time_diff < 3300) {
            self::resetFailedAttempts($ip_address);
            return false;
        } else {
            return true;
        }
    }

    private static function resetFailedAttempts(string $ip_address): void
    {
        $query = "DELETE FROM `failed_login_attempts` WHERE `ip_addr` = :ip_address";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->execute();
    }

    private static function getEntry(string $ip_address): bool
    {
        $query = "SELECT * FROM `failed_login_attempts` WHERE `ip_addr` = :ip_address";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->execute();
        return (bool)$stmt->rowCount();
    }

    public static function getProfilePicture(int $photo_id): string
    {
        $stmt = Database::prepare("SELECT data FROM images WHERE id = :id");
        $stmt->bindParam(':id', $photo_id);
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        return base64_encode($image['data']);
    }
}
