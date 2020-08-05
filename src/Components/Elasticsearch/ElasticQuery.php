<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;
use Elasticsearch\Client;

/**
 * Class ElasticQuery
 * @package App\Components\Elasticsearch
 */
class ElasticQuery
{
    /**
     * @var Model|null
     */
    private ?Model  $model = null;


    /**
     * @var array|null
     */
    private ?array $query = null;


    /**
     * @var Client
     */
    private Client $client;
    /**
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;

    /**
     * ElasticQuery constructor.
     * @param ElasticBuilderQuery $builderQuery
     */
    public function __construct(ElasticBuilderQuery $builderQuery)
    {
        $this->builderQuery = $builderQuery;
    }

    /**
     * @param Model $model
     * @return ElasticQuery
     */
    public function setModel(Model $model): ElasticQuery
    {
        $this->model = $model;
        $this->client = Elastic::connection();
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

    /**
     * @return Model|mixed|null
     */
    public function updateWithInstance()
    {
        $response = $this->client->update($this->query);
        return $this->builderQuery->find($response['id'] ?? $response['_id']);
    }

    /**
     * @return bool
     */
    public function deleteWithInstance():bool
    {
        $delete= $this->client->delete($this->query);
        return (bool)($delete['_shards']['successful'] ?? false);
    }

    /**
     * @return Model|mixed|null
     */
    public function create()
    {
        $saved = $this->client->index($this->query);
        return $this->builderQuery->find($saved['_id'] ?? $saved['id']);
    }

    /**
     * @return Collection
     */
    public function search(): Collection
    {
        return ElasticCollection::make($this->model, $this->client->search($this->query));
    }
}
