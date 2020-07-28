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
     * @param $id
     * @return mixed
     * @see ElasticQuery::find()
     */
    public function find($id):?Model
    {
        $params=[
             'index'=>$this->model->getIndex(),
             'id'=>$id
         ];
        return $this->executeQuery($params, 'find');
    }

    /**
     * @param $id
     * @return Model|mixed|void|null
     */
    public function findOrFail($id)
    {
        return $this->find($id) ?: die(view('errors.404'));
    }

    /**
     * @param array $params
     * @param string $method
     * @return mixed
     */
    public function executeQuery(array $params, string $method)
    {
        return $this->elasticQuery
            ->setQuery($params)
            ->setModel($this->model)
            ->$method();
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
        return $this->executeQuery($params, 'search');
    }
}
