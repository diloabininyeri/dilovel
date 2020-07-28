<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;
use Elasticsearch\Client;

class ElasticQuery
{
    private ?Model  $model=null;


    private ?array $query=null;


    private Client $client;
    /**
     * @param Model $model
     * @return ElasticQuery
     */
    public function setModel(Model $model): ElasticQuery
    {
        $this->model = $model;
        $this->client=Elastic::connection();
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

    /**
     * @return Model|null
     * @see ElasticBuilderQuery::find()
     */
    public function find(): ?Model
    {
        if ($this->client->exists($this->query)) {
            return ModelMapper::instance($this->client->get($this->query), $this->model);
        }
        return null;
    }

    public function search(): Collection
    {
        $result= $this->client->search($this->query);
        return new Collection(ModelMapper::make($this->model, $result));
    }
}
