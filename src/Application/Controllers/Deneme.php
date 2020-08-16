<?php


namespace App\Application\Controllers;

use App\Application\Elastic\Museum;
use App\Components\Collection\Collection;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(): Collection
    {
        $bool = Museum::bool();
        $bool->mustMatchAll();

        $bool->geoBoundingBox('location')
            ->topLeft(74, -71)
            ->bottomRight(40, 40);

        return $bool->get();
    }
}
