<?php
class Logger
{
    public static function log(string $caller, string $type, string $message): void
    {
        self::createLogDir();

        $current_time = date('Y-m-d H:i:s');
        $formatted_message = '[SYSTEM] [' . $caller . '] [' . $type . '] [' . $current_time . ']: ' . $message;
        $file = fopen('logs/log.txt', 'a');
        fwrite($file, $formatted_message . "\n");
        fclose($file);
    }

    public static function clearLog(): void
    {
        self::createLogDir();
        self::createEmptyLog();
    }

    public static function rotateLog(): void
    {
        self::createLogDir();
        self::clearOldLogs();

        // Make sure the log file exists
        if (!file_exists('logs/log.txt')) {
            self::createEmptyLog();
        }

        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        $file = fopen('logs/log.txt', 'r');
        $contents = fread($file, filesize('logs/log.txt'));
        fclose($file);

        $contents = $contents . "\n\n" . 'Fruition Logger - Rotated ' . $current_time . "\n";

        $new_file = fopen('logs/log_' . $current_date . '.txt', 'w');
        fwrite($new_file, $contents);
        fclose($new_file);

        self::clearLog();
    }

    public static function clearOldLogs(): void
    {
        $files = scandir('logs');
        foreach ($files as $file) {
            if (str_contains($file, 'log_')) {
                $file_date = str_replace('log_', '', $file);
                $file_date = str_replace('.txt', '', $file_date);
                $file_date = strtotime($file_date);
                $current_date = strtotime(date('Y-m-d'));
                $date_diff = $current_date - $file_date;

                // If the file is older than 30 days, delete it
                if ($date_diff > 2592000) {
                    unlink('logs/' . $file);
                }
            }
        }
    }

    public static function createLogDir(): void
    {
        if (!file_exists('logs')) {
            mkdir('logs');
        }

        if (!file_exists('logs/log.txt')) {
            self::createEmptyLog();
        }
    }

    public static function createEmptyLog(): void
    {
        $file = fopen('logs/log.txt', 'w');
        fwrite($file, 'Fruition Logger - Created ' . date('Y-m-d H:i:s') . "\n");
        fclose($file);
    }
}