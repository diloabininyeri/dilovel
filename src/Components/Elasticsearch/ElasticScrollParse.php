<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;
use App\Interfaces\ArrayAble;
use phpDocumentor\Reflection\Types\This;

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
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;

    /**
     * ElasticScrollParse constructor.
     * @param array $scrollData
     * @param ElasticBuilderQuery $builderQuery
     */
    public function __construct(array $scrollData, ElasticBuilderQuery  $builderQuery)
    {
        $this->scrollData = $scrollData;
        $this->builderQuery = $builderQuery;
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
        return ElasticCollection::make($this->builderQuery->getModel(), $this->scrollData);
    }
}
