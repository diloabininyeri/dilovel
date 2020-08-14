<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticSearchModel;
use Faker\Factory;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index()
    {
        return ElasticSearchModel::aggregation()->percentiles('age');
    }
}
