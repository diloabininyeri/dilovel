<?php


namespace App\Components\Elasticsearch;

use App\Components\Reflection\RuleAnnotation;

/**
 * Class Model
 * @package App\Components\Elasticsearch
 */
class Model
{

    /**
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->builderQuery = new ElasticBuilderQuery($this);
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @return string
     */
    public function getPrimaryKey():string
    {
        return $this->primaryKey ?? 'id';
    }
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $model = new static();
        if (method_exists($model, 'construct')) {
            $model->construct();
        }
        return $model->$name(...$arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->builderQuery->$name(...$arguments);
    }
}
