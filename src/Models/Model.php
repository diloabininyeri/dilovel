<?php

namespace App\Models;

use App\Components\StringUtil;
use App\Database\BuilderQuery;
use App\Database\Connection;
use PDO;
use const App\Database\config;

/**
 * Class Model
 * @package App\Models
 */
class Model
{
    /**
     * @var BuilderQuery
     */
    private BuilderQuery $builder;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->builder = new BuilderQuery(
            $this,
            $this->pdoConnection()
        );
    }

    /**
     * @return PDO
     */
    public function pdoConnection()
    {
        return Connection::make(config[$this->getConnection()])->pdo();
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table ?? $this->getStaticClassName();
    }

    /**
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden ?? [];
    }


    /**
     * @return string
     */
    private function getStaticClassName()
    {
        $modelName = substr(strrchr(static::class, "\\"), 1);
        return strtolower($modelName);
    }

    /**
     * @return string
     */
    public function getStaticClass()
    {
        return static::class;
    }

    /**
     * @return string
     */
    function getConnection()
    {
        return $this->connection ?? 'default';
    }

    /**
     * @return array
     */
    private function objectableProperties()
    {
        return $this->objectable;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        sscanf($name, 'get%s', $property);
        $property=strtolower($property);
        if (array_key_exists($property,$this->objectableProperties())) {
            return new StringUtil($this->$property);
        }

        return $this->builder->$name(...$arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return (new static())->$name(...$arguments);
    }

    public function __isset($name)
    {
        // TODO: Implement __isset() method.
    }

    public function __set($name, $value)
    {
        $setMethod = 'set' . ucfirst($name).'Attribute';

        if (method_exists($this, $setMethod)) {
            return $this->$name = $this->$setMethod($value);
        }
        return $this->$name = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'getDefault' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (method_exists($this, $name)) {
            return $this->$name();
        }
    }

    /**
     * @param string $relationClass
     * @param string $foreignKey
     * @param string $key
     * @return HasOne
     */
    protected function hasOne(string $relationClass, string $foreignKey, string $key = 'id')
    {
        $hasOne = new HasOne($relationClass, $foreignKey, $key, $this);
        return $hasOne->oneToOne();
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey ?? 'id';
    }


}