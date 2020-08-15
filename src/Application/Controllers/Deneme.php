<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticSearchModel;
use App\Application\Elastic\Museum;
use Faker\Factory;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index()
    {
        $bool= Museum::bool();
        $bool->mustMatchAll();
        $bool->geoDistance('location', 45.555, 45.89999, '5000km');
        return$bool->get();
    }
}
