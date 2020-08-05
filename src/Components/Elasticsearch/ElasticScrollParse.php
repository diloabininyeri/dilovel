<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;

/**
 * Class ElasticScrollParse
 * @package App\Components\Elasticsearch
 */
class ElasticScrollParse
{

    /**
     * @var array
     */
    private array $scrollData;
    /**
     * @var ElasticScrollQuery
     */
    private ElasticScrollQuery $elasticScrollQuery;

    /**
     * ElasticScrollParse constructor.
     * @param array $scrollData
     * @param ElasticScrollQuery $scrollQuery
     */
    public function __construct(array $scrollData, ElasticScrollQuery $scrollQuery)
    {
        $this->scrollData = $scrollData;
        $this->elasticScrollQuery = $scrollQuery;
    }


    /**
     * @return mixed
     */
    public function id()
    {
        return $this->scrollData['_scroll_id'];
    }

    /**
     * @return array
     *
     */
    public function getScrollData(): array
    {
        return $this->scrollData;
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return $this->scrollData['hits']['hits'] ?? [];
    }


    /**
     * @return Collection
     */
    public function collection():Collection
    {
        return ElasticCollection::make($this->elasticScrollQuery->getBuilderQuery()->getModel(), $this->scrollData);
    }

    /**
     * @return array
     */
    public function query():array
    {
        return $this->elasticScrollQuery->getQuery();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->id();
    }
}
