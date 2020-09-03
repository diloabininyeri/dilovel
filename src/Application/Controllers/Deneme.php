<?php


namespace App\Application\Controllers;

use App\Application\Elastic\Museum;
use App\Application\Elastic\Restaurant;
use App\Components\Collection\Collection;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index()
    {
        $bool = Museum::bool();
        $bool->mustMatchAll();

        /*$bool->geoShape('location')
            ->setCoordinates([[13.0, 53.0], [14.0, 52.0]])
            ->setType('envelope');*/

        $bool->geoPolygon('location', [
            "40, -70",
            "30, -80",
            "20, -90"
        ]);



        return $bool->getDetail();
    }
}
