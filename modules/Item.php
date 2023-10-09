<?php


class Item
{

    public int $id;
    public string $author; // TODO: Change to User object
    public string | null $description;
    public string $image;

    // TODO: Change to Type object
    public int $typeId;
    public string $typeName;

    // TODO: Change to Season object
    public int $seasonId;
    public string $seasonName;

    public float $longitude;
    public float $latitude;

    public function __construct(
        int $id,
        string $author,
        string | null $description,
        string $image,
        int $typeId,
        string $typeName,
        int $seasonId,
        string $seasonName,
        float $longitude,
        float $latitude
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->description = $description;
        $this->image = $image;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->seasonId = $seasonId;
        $this->seasonName = $seasonName;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public static function getAll(): array
    {
        $stmt = Database::prepare("
        SELECT
            i.id AS id,
            i.author AS author,
            i.description AS description,
            img.data AS image,
            t.id AS typeId,
            t.name AS typeName,
            s.id AS seasonId,
            s.name AS seasonName,
            i.longitude AS longitude,
            i.latitude AS latitude
        FROM
            items i,
            types t,
            images img,
            seasons s
        WHERE
            i.type = t.id
        AND img.id = i.image
        AND s.id = t.season;");
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $itemObjects = array_map(function ($item) {
            return new Item(
                $item['id'],
                $item['author'],
                $item['description'],
                $item['image'],
                $item['typeId'],
                $item['typeName'],
                $item['seasonId'],
                $item['seasonName'],
                $item['longitude'],
                $item['latitude']
            );
        }, $items);

        return $itemObjects;
    }

    public static function getAllJson(): string
    {
        $itemObjects = self::getAll();

        $items = array_map(function ($item) {
            return [
                'id' => $item->id,
                'author' => $item->author,
                'description' => $item->description,
                'image' => $item->image,
                'typeId' => $item->typeId,
                'typeName' => $item->typeName,
                'seasonId' => $item->seasonId,
                'seasonName' => $item->seasonName,
                'longitude' => $item->longitude,
                'latitude' => $item->latitude
            ];
        }, $itemObjects);

        return json_encode($items);
    }

    public static function getInRadius(
        int $longitude,
        int $latitude,
        int $radius
    ): array {
        $minLongitude = $longitude - $radius;
        $maxLongitude = $longitude + $radius;

        $minLatitude = $latitude - $radius;
        $maxLatitude = $latitude + $radius;

        $stmt = Database::prepare("
        SELECT
            i.id AS id,
            i.author AS author,
            i.description AS description,
            img.data AS image,
            t.id AS typeId,
            t.name AS typeName,
            s.id AS seasonId,
            s.name AS seasonName,
            i.longitude AS longitude,
            i.latitude AS latitude
        FROM
            items i,
            types t,
            images img,
            seasons s
        WHERE
            i.type = t.id
        AND img.id = i.image
        AND s.id = t.season
        AND i.longitude BETWEEN :minLongitude AND :maxLongitude 
        AND i.latitude BETWEEN :minLatitude AND :maxLatitude;");
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
                $item['image'],
                $item['typeId'],
                $item['typeName'],
                $item['seasonId'],
                $item['seasonName'],
                $item['longitude'],
                $item['latitude']
            );
        }, $items);

        return $itemObjects;
    }

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
                'image' => $item->image,
                'typeId' => $item->typeId,
                'typeName' => $item->typeName,
                'seasonId' => $item->seasonId,
                'seasonName' => $item->seasonName,
                'longitude' => $item->longitude,
                'latitude' => $item->latitude
            ];
        }, $itemObjects);

        return json_encode($items);
    }
}