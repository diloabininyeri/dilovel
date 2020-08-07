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
    public function index(): Collection
    {
        return ElasticSearchModel::searchWithSql("select * from users where name='Ege' and age between 25 and 45 order by age asc  limit 10");
    }
}
