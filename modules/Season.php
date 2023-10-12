<?php

class Season
{
    public int $id;
    public string $name;
    public DateTime $start;
    public DateTime $end;

    public function __construct(int $id, string $name, DateTime $start, DateTime $end)
    {
        $this->id = $id;
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
    }

    public static function getAll(): array
    {
        $stmt = Database::prepare("
        SELECT
            id,
            name,
            start,
            end                        
        FROM
            seasons;");
        $stmt->execute();

        $seasons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $seasonObjects = array_map(function ($season) {
            return new Season(
                $season['id'],
                $season['name'],
                new DateTime($season['start']),
                new DateTime($season['end'])
            );
        }, $seasons);

        return $seasonObjects;
    }
}
