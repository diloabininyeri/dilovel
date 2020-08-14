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
        return Museum::aggregation()->geoCentroid('location');
    }
}
