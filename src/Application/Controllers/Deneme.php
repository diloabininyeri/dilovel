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
        $bool->geoDistance('location', 45.555, 45.89999, '5000km');
        return $bool->get();
    }
}
