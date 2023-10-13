<?php


class Item
{

    public int $id;
    public string $author; // TODO: Change to User object
    public string | null $description;

    // TODO: Change to Type object
    public int $typeId;
    public string $typeName;
    public string $typeLabel;

    // TODO: Change to Season object
    public int $seasonId;
    public string $seasonName;

    public float $longitude;
    public float $latitude;

    public float $favorited;

    public function __construct(
        int $id,
        string $author,
        string | null $description,
        int $typeId,
        string $typeName,
        string $typeLabel,
        int $seasonId,
        string $seasonName,
        float $longitude,
        float $latitude,
        bool $favorited
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->description = $description;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->typeLabel = $typeLabel;
        $this->seasonId = $seasonId;
        $this->seasonName = $seasonName;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->favorited = $favorited;
    }

    public static function getAll(int | null $season, bool $favorites): array
    {
        $season = $season ?? 0;
        $userId = $_SESSION['user_id'] ?? -1;

        $stmt = Database::prepare("
        SELECT
            i.id AS id,
            u.username AS author,
            i.description AS description,
            t.id AS typeId,
            t.name AS typeName,
            t.label AS typeLabel,
            s.id AS seasonId,
            s.name AS seasonName,
            i.longitude AS longitude,
            i.latitude AS latitude,
            (SELECT COUNT(*) FROM favorites f WHERE f.user = :userId AND f.item = i.id) AS favorited
        FROM
            items i,
            users u,
            types t,
            seasons s
        WHERE
            i.author = u.id 
        AND i.type = t.id
        AND s.id = t.season
        AND (:seasonId = 0 OR :seasonId2 = s.id);");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':seasonId', $season);
        $stmt->bindParam(':seasonId2', $season);
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $itemObjects = [];
        foreach ($items as $item) {
            if ($favorites && !$item['favorited']) {
                continue;
            }

            $itemObjects[] = new Item(
                $item['id'],
                $item['author'],
                $item['description'],
                $item['typeId'],
                $item['typeName'],
                $item['typeLabel'],
                $item['seasonId'],
                $item['seasonName'],
                $item['longitude'],
                $item['latitude'],
                $item['favorited']
            );
        }

        return $itemObjects;
    }

    public static function getAllJson(int | null $season, bool $favorites): string
    {
        $itemObjects = self::getAll($season, $favorites);

        // Remove unapproved items
        $itemObjects = self::filterUnapproved($itemObjects);

        // Build an array containing only the item data
        $items = array_map(function ($item) {
            return [
                'id' => $item->id,
                'author' => $item->author,
                'description' => $item->description,
                'typeId' => $item->typeId,
                'typeName' => $item->typeName,
                'typeLabel' => $item->typeLabel,
                'seasonId' => $item->seasonId,
                'seasonName' => $item->seasonName,
                'longitude' => $item->longitude,
                'latitude' => $item->latitude,
                'favorited' => $item->favorited
            ];
        }, $itemObjects);


        return json_encode($items);
    }

    // Code works just not being used anymore.
    public static function getInRadius(
        int $longitude,
        int $latitude,
        int $radius
    ): array {
        $userId = $_SESSION['user_id'] ?? -1;

        $minLongitude = $longitude - $radius;
        $maxLongitude = $longitude + $radius;

        $minLatitude = $latitude - $radius;
        $maxLatitude = $latitude + $radius;

        $stmt = Database::prepare("
        SELECT
            i.id AS id,
            i.author AS author,
            i.description AS description,
            t.id AS typeId,
            t.name AS typeName,
            s.id AS seasonId,
            s.name AS seasonName,
            i.longitude AS longitude,
            i.latitude AS latitude,
            (SELECT COUNT(*) FROM favorites f WHERE f.user = :userId AND f.item = i.id) AS favorited
        FROM
            items i,
            types t,
            seasons s
        WHERE
            i.type = t.id
        AND s.id = t.season
        AND i.longitude BETWEEN :minLongitude AND :maxLongitude 
        AND i.latitude BETWEEN :minLatitude AND :maxLatitude;");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':minLongitude', $minLongitude);
        $stmt->bindParam(':maxLongitude', $maxLongitude);
        $stmt->bindParam(':minLatitude', $minLatitude);
        $stmt->bindParam(':maxLatitude', $maxLatitude);
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $itemObjects = array_map(function ($item) {
            return new Item(
                $item['id'],
                $item['author'],
                $item['description'],
                $item['typeId'],
                $item['typeName'],
                $item['typeLabel'],
                $item['seasonId'],
                $item['seasonName'],
                $item['longitude'],
                $item['latitude'],
                $item['favorited']
            );
        }, $items);

        return $itemObjects;
    }

    // Code works just not being used anymore.
    public static function getInRadiusJson(
        int $longitude,
        int $latitude,
        int $radius
    ): string {
        $itemObjects = self::getInRadius($longitude, $latitude, $radius);

        $items = array_map(function ($item) {
            return [
                'id' => $item->id,
                'author' => $item->author,
                'description' => $item->description,
                'typeId' => $item->typeId,
                'typeName' => $item->typeName,
                'seasonId' => $item->seasonId,
                'seasonName' => $item->seasonName,
                'longitude' => $item->longitude,
                'latitude' => $item->latitude,
                'favorited' => $item->favorited
            ];
        }, $itemObjects);

        return json_encode($items);
    }

    public static function getTypeSeason(mixed $type)
    {
        $stmt = Database::prepare("
        SELECT
            s.id AS seasonId
        FROM
            types t,
            seasons s
        WHERE
            t.id = :typeId
        AND s.id = t.season;");
        $stmt->bindParam(':typeId', $type);
        $stmt->execute();

        $season = $stmt->fetch(PDO::FETCH_ASSOC);

        return $season['seasonId'];
    }

    private static function filterUnapproved(array $itemObjects): array
    {
        // Get unapproved items
        $stmt = Database::prepare("SELECT * FROM submissions WHERE approved = 0");
        $stmt->execute();

        $unapprovedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Remove unapproved items
        foreach ($unapprovedItems as $unapprovedItem) {
            foreach ($itemObjects as $key => $itemObject) {
                if ($itemObject->id == $unapprovedItem['item']) {
                    unset($itemObjects[$key]);
                }
            }
        }

        return $itemObjects;
    }

    public static function exists(mixed $item): bool
    {
        $stmt = Database::prepare("SELECT * FROM items WHERE id = :itemId");
        $stmt->bindParam(':itemId', $item);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function isApproved(mixed $item): bool
    {
        $stmt = Database::prepare("SELECT * FROM submissions WHERE item = :itemId");
        $stmt->bindParam(':itemId', $item);
        $stmt->execute();

        $submission = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($submission['approved'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function get(mixed $item): Item
    {
        $stmt = Database::prepare("
        SELECT
            i.id AS id,
            u.email AS author,
            i.description AS description,
            t.id AS typeId,
            t.name AS typeName,
            t.label AS typeLabel,
            s.id AS seasonId,
            s.name AS seasonName,
            i.longitude AS longitude,
            i.latitude AS latitude,
            (SELECT COUNT(*) FROM favorites f WHERE f.user = :userId AND f.item = i.id) AS favorited
        FROM
            items i,
            users u,
            types t,
            seasons s
        WHERE
            i.id = :itemId
        AND i.author = u.id 
        AND i.type = t.id
        AND s.id = t.season;");
        $stmt->bindParam(':itemId', $item);
        $stmt->bindParam(':userId', $_SESSION['user_id']);
        $stmt->execute();

        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Item(
            $item['id'],
            $item['author'],
            $item['description'],
            $item['typeId'],
            $item['typeName'],
            $item['typeLabel'],
            $item['seasonId'],
            $item['seasonName'],
            $item['longitude'],
            $item['latitude'],
            $item['favorited']
        );
    }

    public static function getUnapprovedSubmissions(): array
    {
        $stmt = Database::prepare("
        SELECT
            i.id AS id,
            u.username AS author,
            i.description AS description,
            t.id AS typeId,
            t.name AS typeName,
            t.label AS typeLabel,
            s.id AS seasonId,
            s.name AS seasonName,
            i.longitude AS longitude,
            i.latitude AS latitude,
            (SELECT COUNT(*) FROM favorites f WHERE f.user = :userId AND f.item = i.id) AS favorited
        FROM
            items i,
            users u,
            types t,
            seasons s
        WHERE
            i.author = u.id 
        AND i.type = t.id
        AND s.id = t.season
        AND i.id IN (SELECT item FROM submissions WHERE approved = 0);");
        $stmt->bindParam(':userId', $_SESSION['user_id']);
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($item) {
            return new Item(
                $item['id'],
                $item['author'],
                $item['description'],
                $item['typeId'],
                $item['typeName'],
                $item['typeLabel'],
                $item['seasonId'],
                $item['seasonName'],
                $item['longitude'],
                $item['latitude'],
                $item['favorited']
            );
        }, $items);
    }
}
