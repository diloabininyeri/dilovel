<?php


namespace App\Components\Elasticsearch;

/**
 * Class ElasticAggregationQuery
 * @package App\Components\Elasticsearch
 */
class ElasticAggregationQuery
{


    /**
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;

    /**
     * ElasticAggregationQuery constructor.
     * @param ElasticBuilderQuery $builderQuery
     */
    public function __construct(ElasticBuilderQuery $builderQuery)
    {
        $this->builderQuery = $builderQuery;
    }


    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->builderQuery->getModel()->getIndex();
    }
}
