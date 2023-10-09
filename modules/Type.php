<?php


class Type
{
    public int $id;
    public string $name;
    public string $label;

    // TODO: Change to Season object
    public int $seasonId;
    public string $seasonName;

    public function __construct(
        int $id,
        string $name,
        string $label,
        int $seasonId,
        string $seasonName
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->seasonId = $seasonId;
        $this->seasonName = $seasonName;
    }

    public static function getAll(): array
    {
        $stmt = Database::prepare("
            SELECT
                t.id AS id,
                t.name AS name,
                t.label AS label,
                s.id AS seasonId,
                s.name AS seasonName
            FROM
                types t,
                seasons s
            WHERE
                s.id = t.season;
        ");
        $stmt->execute();

        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $typeObjects = array_map(function ($type) {
            return new Type(
                $type['id'],
                $type['name'],
                $type['label'],
                $type['seasonId'],
                $type['seasonName']
            );
        }, $types);

        return $typeObjects;
    }
}
