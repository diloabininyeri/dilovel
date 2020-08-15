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
            ->geoHash('dr5r9ydj2y73', 'drj7teegpus6');
        return $bool->get();
    }
}
