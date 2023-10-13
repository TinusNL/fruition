<?php

class Location
{

    public static function getMapsLink(float $longitude, float $latitude): string
    {
        return "https://www.google.com/maps/dir/?api=1&destination=" . $longitude . "," . $latitude;
    }
}