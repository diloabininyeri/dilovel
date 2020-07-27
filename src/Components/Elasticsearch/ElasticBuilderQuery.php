<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;

/**
 * Class ElasticBuilderQuery
 * @package App\Components\Elasticsearch
 */
class ElasticBuilderQuery
{
    /**
     * @var Model
     */
    private Model $model;

    /**
     * @var ElasticQuery
     */
    private ElasticQuery $elasticQuery;


    /**
     * ElasticBuilderQuery constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->elasticQuery = new ElasticQuery();
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        $params = [
            'index' => $this->model->getIndex(),
            'body' => [
                'query' =>
                    [
                        'match_all' => (object)[]
                    ]
            ]
        ];
        return $this->elasticQuery
            ->setQuery($params)
            ->setModel($this->model)
            ->search();
    }
}
