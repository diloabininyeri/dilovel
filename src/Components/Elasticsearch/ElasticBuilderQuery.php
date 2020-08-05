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
        $this->elasticQuery = new ElasticQuery($this);
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     * @see ElasticQuery::find()
     */
    public function find($id): ?Model
    {
        $params = [
            'index' => $this->model->getIndex(),
            'id' => $id
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
     * @param $id
     * @param callable $callable
     * @return Model|mixed
     */
    public function findOr($id, callable $callable)
    {
        return $this->find($id) ?? $callable();
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
     * @return array
     */
    private function getModelAttributes():array
    {
        return get_object_vars($this->model);
    }
    /**
     * @return mixed
     */
    public function save():Model
    {
        $attributes = $this->getModelAttributes();

        if ($this->model->isHasPrimaryKeyValue()) {
            $params = $this->builderUpdateQuery($this->model->getPrimaryKeyValue(), $attributes);
            return $this->executeQuery($params, 'updateWithInstance');
        }
        return $this->executeQuery($this->builderQuery($attributes), 'create');
    }

    /**
     * @return bool
     */
    public function delete():bool
    {
        if ($this->model->isHasPrimaryKeyValue()) {
            return $this->executeQuery($this->builderDeleteQuery(), 'deleteWithInstance');
        }

        return false;
    }

    /**
     * @param $id
     * @param array $params
     * @return array
     */
    private function builderUpdateQuery($id, array $params):array
    {
        return [
            'index' => $this->model->getIndex(),
            'id'=>$id,
            'body' =>[
                'doc'=>$params
            ]
        ];
    }

    /**
     * @return array
     */
    private function builderDeleteQuery():array
    {
        return [
            'index' => $this->model->getIndex(),
            'id' => $this->model->getPrimaryKeyValue()
        ];
    }
    /**
     * @param array $params
     * @return array
     */
    private function builderQuery(array $params): array
    {
        return [
            'index' => $this->model->getIndex(),
            'body' => $params
        ];
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

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return ElasticBoolQuery
     */
    public function bool(): ElasticBoolQuery
    {
        return new ElasticBoolQuery($this);
    }
}
