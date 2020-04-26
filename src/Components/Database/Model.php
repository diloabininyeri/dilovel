<?php

namespace App\Components\Database;


use JsonException;
use PDO;
use const App\Database\config;


/**
 * Class Model
 * @package App\Models
 */
abstract class Model
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
    public function pdoConnection(): PDO
    {
        return Connection::make(config[$this->getConnection()])->pdo();
    }

    /**
     * @return mixed
     * @throws JsonException
     */
    public function toArray()
    {
        return json_decode(json_encode($this), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return mixed
     */
    public function getTable(): string
    {
        return $this->table ?? $this->getStaticClassName();
    }

    /**
     * @return array
     */
    public function getHidden(): array
    {
        return $this->hidden ?? [];
    }


    /**
     * @return string
     */
    private function getStaticClassName(): string
    {
        $modelName = substr(strrchr(static::class, "\\"), 1);
        return strtolower($modelName);
    }

    /**
     * @return string
     */
    public function getStaticClass(): string
    {
        return static::class;
    }

    /**
     * @return string
     */
    public function getConnection(): string
    {
        return $this->connection ?? 'default';
    }

    /**
     * @return array
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    private function objectableProperties(): array
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
        $property = strtolower($property);
        if (array_key_exists($property, $this->objectableProperties())) {
            $objectAbleClass = $this->objectableProperties()[$property];
            return new $objectAbleClass($this->$property);
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
        $setMethod = 'set' . ucfirst($name) . 'Attribute';

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
        return null;
    }

    /**
     * @param string $relationClass
     * @param string $foreignKey
     * @param string $key
     * @return HasOne
     */
    protected function hasOne(string $relationClass, string $foreignKey, string $key = 'id'): HasOne
    {
        $hasOne = new HasOne($relationClass, $foreignKey, $key, $this);
        return $hasOne->oneToOne();
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey ?? 'id';
    }


}