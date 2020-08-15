<?php


namespace App\Application\Controllers;

use App\Application\Elastic\Museum;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index()
    {
        $bool = Museum::bool();
        $bool->mustMatch('city', 'Paris');
        $bool->geoBoundingBox('location')
            ->wktBbox(-74.1, -71.12, 40.73, 40.01);
        return $bool->get();
    }
}
