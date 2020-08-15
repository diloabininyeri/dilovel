<?php


namespace App\Components\Elasticsearch;

/**
 * Class Model
 * @package App\Components\Elasticsearch
 * @property $_id
 * @method static ElasticBoolQuery bool();
 */
class Model
{

    /**
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;

    /**
     * @var array
     */
    private array $attributes = [];


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
    public function getStaticClass():string
    {
        return static::class;
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
     * @return array
     */
    public function __debugInfo()
    {
        return $this->attributes;
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

    /**
     * @param array $attributes
     * @return Model
     */
    public function setAttributes(array $attributes): Model
    {
        $this->attributes = $attributes;
        return $this;
    }


    public function getPrimaryKeyValue()
    {
        if ($this->isHasPrimaryKeyValue()) {
            return $this->id ?? $this->_id;
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isHasPrimaryKeyValue():bool
    {
        return !empty($this->id ?? $this->_id ?? null);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
