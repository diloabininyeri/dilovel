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
     * @return TermAggregationParse
     */
    public function terms(string $key, int $size=10): TermAggregationParse
    {
        $params = [
            'index' => 'users',
            'body' => [
                'aggs' => [
                    'terms_aggregation' => [
                        'terms' => [
                            'field' => $key,
                            'size'=>$size
                        ]
                    ],
                ]
            ]
        ];

        $result=$this->builderQuery->getClient()->search($params);
        return new TermAggregationParse($result);
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->builderQuery->getModel()->getIndex();
    }
}
