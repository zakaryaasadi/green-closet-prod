<?php

namespace App\Helpers;

use App\Traits\ApiResponse;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;

class SpatialHelper
{
    use ApiResponse;

    /**
     * @param $areas
     * @return Polygon
     */
    public static function getPolygon($areas): Polygon
    {
        $points = [];
        foreach ($areas as $area) {
            $lat = $area['lat'];
            $lng = $area['lng'];
            $points[] = new Point($lat, $lng);
        }

        return new Polygon([new LineString($points)]);
    }
}
