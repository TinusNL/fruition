<?php


class Item
{

    public int $id;
    public string $author; // TODO: Change to User object
    public string $description;

    // TODO: Change to Type object
    public int $typeId;
    public string $typeName;

    public int $longitude;
    public int $latitude;

    public function __construct(
        int $id,
        string $author,
        string $description,
        int $typeId,
        string $typeName,
        int $longitude,
        int $latitude
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->description = $description;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public static function getAll()
    {
    } // Probable not going to be used. Because of resources

    public static function getInRadius(
        int $longitude,
        int $latitude,
        int $radius
    ) {
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
            i.longitude AS longitude,
            i.latitude AS latitude
        FROM
            items i,
            types t
        WHERE
            i.longitude BETWEEN :minLongitude AND :maxLongitude 
        AND i.latitude BETWEEN :minLatitude AND :maxLatitude;");
        $stmt->bindParam(':minLongitude', $minLongitude);
        $stmt->bindParam(':maxLongitude', $maxLongitude);
        $stmt->bindParam(':minLatitude', $minLatitude);
        $stmt->bindParam(':maxLatitude', $maxLatitude);
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $items = array_map(function ($item) {
            return new Item(
                $item['id'],
                $item['author'],
                $item['description'],
                $item['typeId'],
                $item['typeName'],
                $item['longitude'],
                $item['latitude']
            );
        }, $items);

        return $items;
    }
}
