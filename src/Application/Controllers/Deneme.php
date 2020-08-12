<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticSearchModel;
use App\Components\Collection\Collection;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index()
    {
        return ElasticSearchModel::aggregation()->getModel();
    }
}
