<?php
class Logger
{
    public static function log(string $caller, string $type, string $message): void
    {
        $current_time = date('Y-m-d H:i:s');
        $formatted_message = '[SYSTEM] [' . $caller . '] [' . $type . '] [' . $current_time . ']: ' . $message;
        $file = fopen('logs/log.txt', 'a');
        fwrite($file, $formatted_message . "\n");
        fclose($file);
    }

    public static function clearLog(): void
    {
        $file = fopen('logs/log.txt', 'w');
        fwrite($file, '');
        fclose($file);
    }
}