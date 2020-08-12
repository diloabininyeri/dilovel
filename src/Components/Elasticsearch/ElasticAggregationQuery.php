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
     * @param string $key
     * @param int $size
     * @return array
     */
    public function terms(string $key,int $size=10): array
    {
        $params = [
            'index' => 'users',
            'body' => [
                'aggs' => [
                    'term_aggregation' => [
                        'terms' => [
                            'field' => $key,
                            'size'=>$size
                        ]
                    ],

                ]
            ]
        ];


        return $this->builderQuery->getClient()->search($params);
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->builderQuery->getModel()->getIndex();
    }
}
