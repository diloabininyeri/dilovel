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
     * @return array
     */
    public function stats(string $key): array
    {
        $params = [
            'index' => $this->builderQuery->getModel()->getIndex(),
            'body' => [
                'aggs' => [
                    'stats_aggregation' => [
                        'stats' => [
                            'field' => $key
                        ]
                    ],
                ]
            ]
        ];
        $results= $this->builderQuery->getClient()->search($params);
        return $results['aggregations']['stats_aggregation'];
    }

    /**
     * @param string $key
     * @param int $size
     * @return TermAggregationParse
     */
    public function terms(string $key, int $size = 10): TermAggregationParse
    {
        $params = [
            'index' => $this->builderQuery->getModel()->getIndex(),
            'body' => [
                'aggs' => [
                    'terms_aggregation' => [
                        'terms' => [
                            'field' => $key,
                            'size' => $size
                        ]
                    ],
                ]
            ]
        ];
        return new TermAggregationParse(
            $this->builderQuery->getClient()->search($params)
        );
    }
}
