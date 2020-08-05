<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;

/**
 * Class ElasticCollection
 * @package App\Components\Elasticsearch
 */
class ElasticCollection
{

    /**
     * @param Model $model
     * @param array $data
     * @return Collection
     */
    public static function make(Model  $model, array $data):Collection
    {
        return new Collection(ModelMapper::make($model, $data));
    }
}
