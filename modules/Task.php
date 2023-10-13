<?php

class Task
{
    public static function checkTasks(): void
    {
        $tasks = self::getTasks();

        foreach ($tasks as $task) {
            $task_name = $task['task'];
            $task_last_run = $task['last_run'];

            // $task_operating_times is a string in the format of j. use this to get the day of the month
            if ($task_last_run < strtotime('first day of this month')) {
                self::updateTask($task_name, $task['id']);
            }
        }
    }

    public static function getTasks(): array
    {
        $query = "SELECT * FROM schedule";
        $stmt = Database::prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateTask(string $task_name, int $task_id): void
    {
        $current_time = date('Y-m-d H:i:s');
        $query = "UPDATE schedule SET last_run = :last_run WHERE id = :id";
        $stmt = Database::prepare($query);
        $stmt->bindParam(':last_run', $current_time);
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();

        self::runTask($task_name);
    }

    private static function runTask(string $task_name): void
    {
        match ($task_name) {
            'log_rotate' => Logger::rotateLog(),
            'clear_failed_attempts' => User::clearFailedAttempts(),
            default => Logger::log('Task', 'ERROR', 'Task not found: ' . $task_name),
        };
    }
}