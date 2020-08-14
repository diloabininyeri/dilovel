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
     * @param string $aggregation
     * @param string $aggregationName
     * @return array
     */
    private function aggregationArray(string $key, string $aggregation, string $aggregationName): array
    {
        return [
            'index' => $this->builderQuery->getModel()->getIndex(),
            'body' => [
                'aggs' => [
                    $aggregationName => [
                        $aggregation => [
                            'field' => $key
                        ]
                    ],
                ]
            ]
        ];
    }


    /**
     * @param string $key
     * @param array $percents
     * @return array
     */
    public function percentiles(string $key, array $percents=[]):array
    {
        $params= [
            'index' => $this->builderQuery->getModel()->getIndex(),
            'body' => [
                'aggs' => [
                    'percentiles' => [
                        'percentiles' => [
                            'field' => $key,
                            'percents'=>$percents ?: range(0, 100, 5)
                        ]
                    ],
                ]
            ]
        ];

        $result= $this->builderQuery->getClient()->search($params);
        return $result['aggregations']['percentiles']['values'];
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function max(string $key)
    {
        $params = $this->aggregationArray($key, 'max', 'max_aggregation');
        $results = $this->builderQuery->getClient()->search($params);
        return $results['aggregations']['max_aggregation']['value'];
    }


    /**
     * @param string $key
     * @return mixed
     */
    public function count(string $key)
    {
        return $this->stats($key)['count'];
    }
    /**
     * @param string $key
     * @return mixed
     */
    public function min(string $key)
    {
        $params = $this->aggregationArray($key, 'min', 'min_aggregation');
        $results = $this->builderQuery->getClient()->search($params);
        return $results['aggregations']['min_aggregation']['value'];
    }
    /**
     * @param string $key
     * @return int
     */
    public function sum(string $key):int
    {
        $params = $this->aggregationArray($key, 'sum', 'sum_aggregation');
        $results = $this->builderQuery->getClient()->search($params);
        return $results['aggregations']['sum_aggregation']['value'];
    }

    /**
     * @param string $key
     * @return float
     */
    public function avg(string $key): float
    {
        $params = $this->aggregationArray($key, 'avg', 'avg_aggregation');
        $results = $this->builderQuery->getClient()->search($params);
        return $results['aggregations']['avg_aggregation']['value'];
    }

    /**
     * @param string $key
     * @return array
     */
    public function stats(string $key): array
    {
        $params = $this->aggregationArray($key, 'stats', 'stats_aggregation');
        $results = $this->builderQuery->getClient()->search($params);
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
