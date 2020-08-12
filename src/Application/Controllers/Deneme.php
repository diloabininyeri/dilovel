<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticSearchModel;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index()
    {
        $terms= ElasticSearchModel::aggregation()->terms('name.keyword', 25);
        return $terms->getBuckets();
    }
}
