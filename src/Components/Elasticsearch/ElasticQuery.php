<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;

class ElasticQuery
{
    private ?Model  $model=null;


    private ?array $query=null;

    /**
     * @param Model $model
     * @return ElasticQuery
     */
    public function setModel(Model $model): ElasticQuery
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array $query
     * @return ElasticQuery
     */
    public function setQuery(array $query): ElasticQuery
    {
        $this->query = $query;
        return $this;
    }

    public function search()
    {
        $result= Elastic::connection()->search($this->query);
        return new Collection(ModelMapper::make($this->model, $result));
    }
}
