<?php
class Setup
{
    public static function setup()
    {
        // Get connection from Database
        $conn = new Database();

        // If the tables exist, return
        $stmt = $conn->prepare("SHOW TABLES LIKE 'items'");
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            return;
        }

        // Create tables and insert default data
        $createStatements = [
            "CREATE TABLE IF NOT EXISTS `images` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `data` LONGBLOB NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `seasons` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `start` DATE NOT NULL,
                `end` DATE NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `types` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `label` VARCHAR(255) NOT NULL,
                `season` INT(11) NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`season`) REFERENCES `seasons` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `users` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `role` INT(11) NOT NULL,
                `username` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `profile_image` INT(11) NULL DEFAULT NULL,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
                UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
                FOREIGN KEY (`profile_image`) REFERENCES `images` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `items` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `author` INT(11) NOT NULL,
                `description` VARCHAR(255) NULL DEFAULT NULL,
                `image` INT(11) NOT NULL,
                `type` INT(11) NOT NULL,
                `longitude` FLOAT NOT NULL,
                `latitude` FLOAT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`author`) REFERENCES `users` (`id`),
                FOREIGN KEY (`image`) REFERENCES `images` (`id`),
                FOREIGN KEY (`type`) REFERENCES `types` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `submissions` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `approved` TINYINT(1) NOT NULL DEFAULT 0,
                `author` INT(11) NOT NULL,
                `item` INT(11) NOT NULL,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`author`) REFERENCES `users` (`id`),
                FOREIGN KEY (`item`) REFERENCES `items` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `favorites` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `user` INT(11) NOT NULL,
                `item` INT(11) NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`user`) REFERENCES `users` (`id`),
                FOREIGN KEY (`item`) REFERENCES `items` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `roles` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `failed_login_attempts` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `ip_addr` VARCHAR(255) NOT NULL,
                `attempts` VARCHAR(255) NOT NULL,
                `last_attempt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        ];
        foreach ($createStatements as $sql) {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        // Insert default data
        $insertStatements = [
            "INSERT IGNORE INTO `seasons` (`id`, `name`, `start`, `end`) VALUES
                (1, 'Spring', '0000-03-21', '0000-06-21'),
                (2, 'Summer', '0000-06-21', '0000-09-23'),
                (3, 'Autumn', '0000-09-23', '0000-12-21'),
                (4, 'Winter', '0000-12-21', '0000-03-21'),
                (5, 'All', '0000-01-01', '0000-12-31');",
            "INSERT IGNORE INTO `types` (`id`, `name`, `label`, `season`) VALUES
                (1, 'apple', 'Apple', 2),
                (2, 'apricot', 'Apricot', 2),
                (3, 'berry', 'Berries', 1),
                (4, 'grapefruit', 'Grapefruit', 4),
                (5, 'grapes', 'Grapes', 2),
                (6, 'lemon', 'Lemon', 4),
                (7, 'orange', 'Orange', 4),
                (8, 'pear', 'Pear', 3),
                (9, 'strawberry', 'Strawberry', 2),
                (10, 'other', 'Other', 5);",
            "INSERT IGNORE INTO `roles` (`id`, `name`) VALUES
                (1, 'guest'),
                (2, 'user'),
                (3, 'admin'),
                (4, 'owner'),
                (5, 'bot');",
            "INSERT IGNORE INTO `users` (`id`, `role`, `username`, `email`, `password`, `profile_image`, `created_at`, `updated_at`) VALUES
                (1, 5, 'deleted user', 'no-reply@fruition.city', '', NULL, '2020-05-01 00:00:00', '2020-05-01 00:00:00');"
        ];
        foreach ($insertStatements as $sql) {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
    }
}