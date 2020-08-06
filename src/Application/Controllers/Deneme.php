<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticModelExample;
use App\Components\Collection\Collection;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index():Collection
    {
        $bool=ElasticModelExample::bool();

        return  $bool->mustMatchAll()
            ->size(50)
            ->sortBy('age')
            ->get();
    }
}
