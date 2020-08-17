<?php


namespace App\Application\Controllers;

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
        $bool = Restaurant::bool();
        $bool->mustMatchAll();

        $bool->geoShape('location')
            ->setCoordinates([[13.0, 53.0], [14.0, 52.0]])
            ->setType('envelope');


        return $bool->getQuery();
    }
}
