<?php


namespace App\Components\Elasticsearch;

use Elasticsearch\Client;
use stdClass;

/**
 * Class ElasticScrollQuery
 * @package App\Components\Elasticsearch
 */
class ElasticScrollQuery
{

    /**
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;


    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var array
     */
    private array $query = [];

    /**
     * @var string|null
     */
    private ?string $scrollTime = null;

    /**
     * @var int|null
     */
    private ?int  $size = null;

    /**
     * ElasticScrollQuery constructor.
     * @param ElasticBuilderQuery $builderQuery
     */
    public function __construct(ElasticBuilderQuery $builderQuery)
    {
        $this->client = Elastic::connection();
        $this->builderQuery = $builderQuery;
    }

    /**
     * @return $this
     */
    public function matchAll(): self
    {
        $this->query['match_all'] = new stdClass();
        return $this;
    }

    /**
     * @param string $key
     * @param array $logical
     * @return $this
     */
    public function range(string $key, array $logical):self
    {
        $this->query['range']=[
            $key=>$logical
        ];
        return $this;
    }

    /**
     * @param string $time
     * @return $this
     */
    public function life(string $time = '60s'): self
    {
        $this->scrollTime = $time;
        return $this;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function size(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        $query= [
            'index' => $this->builderQuery->getModel()->getIndex(),
            'body' => $this->getBodyQuery()
        ];
        if ($this->size) {
            $query['size'] = $this->size;
        }
        if ($this->scrollTime) {
            $query['scroll'] = $this->scrollTime;
        }

        return $query;
    }

    /**
     * @return array
     */
    private function getBodyQuery(): array
    {
        return [
            'query' => $this->query
        ];
    }

    /**
     * @return ElasticScrollParse
     */
    public function get():ElasticScrollParse
    {
        return new ElasticScrollParse($this->client->search($this->getQuery()), $this);
    }

    /**
     * @return ElasticBuilderQuery
     */
    public function getBuilderQuery(): ElasticBuilderQuery
    {
        return $this->builderQuery;
    }
}
