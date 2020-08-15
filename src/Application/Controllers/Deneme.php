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
            ->topLeft(45, 8)
            ->bottomRight(4, 5);
        return $bool->get();
    }
}
