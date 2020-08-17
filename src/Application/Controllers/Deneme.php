<?php


namespace App\Application\Controllers;

use App\Application\Elastic\Restaurant;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index()
    {
        /**
         * ->topLeft(74, -71)
         *  ->bottomRight(40, 40);
         */
        $bool = Restaurant::bool();
        $bool->mustMatchAll();

        $bool->geoShape('location')
            ->shape([[ 13.0, 53.0 ], [ 14.0, 52.0 ]])
            ->setType('envelope');


        return $bool->get();
    }
}
