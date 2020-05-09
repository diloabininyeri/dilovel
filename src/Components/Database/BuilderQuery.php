<?php

namespace App\Components\Database;

use App\Components\Collection\Collection;
use PDO;

/**
 * Class BuilderQuery
 * @package App\Database
 */
class BuilderQuery
{
    /**
     * @var Model
     */
    private Model $modelInstance;

    /**
     * @var PDO
     */
    private PDO $pdo;

    private ?string $query = null;


    private array $bindArray = [];

    private ?string $orderBy = null;

    private bool $isWhereUsed = false;

    private string  $whereQuery;


    /**
     * BuilderQuery constructor.
     * @param Model $model
     * @param PDO $pdo
     */
    public function __construct(Model $model, PDO $pdo)
    {
        $this->modelInstance = $model;
        $this->pdo = $pdo;
    }


    /**
     * @param $key
     * @param $operator
     * @param $value
     * @return $this
     */
    public function where($key, $value, $operator = '='): self
    {
        if ($this->isWhereUsed()) {
            $this->whereQuery .= " AND $key$operator:where_$key";

        } else {

            $this->whereQuery = " WHERE $key$operator:where_$key ";
        }

        $this->bindArray[":where_$key"] = is_string($value) ? "'$value'" : $value;
        $this->isWhereUsed = true;
        return $this;
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     * @return $this
     */
    public function orWhere($key, $value, $operator = '='): self
    {
        if ($this->isWhereUsed()) {
            $this->whereQuery .= " OR $key$operator:or_where$key";
        } else {
            $this->whereQuery = " WHERE $key$operator:or_where$key ";
        }

        $this->bindArray[":or_where$key"] = is_string($value) ? "'$value'" : $value;
        $this->isWhereUsed = true;
        return $this;
    }

    /**
     * @return array
     */
    public function getBindArray(): array
    {
        return $this->bindArray;
    }


    /**
     * @param array $bindArray
     * @return BuilderQuery
     */
    private function setBindArray(array $bindArray): BuilderQuery
    {
        $this->bindArray = $bindArray;
        return $this;
    }

    /**
     * @return string
     */
    private function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     * @return BuilderQuery
     */
    private function setOrderBy(string $orderBy): BuilderQuery
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return Model
     */
    private function getModelInstance(): Model
    {
        return $this->modelInstance;
    }

    private function getTable()
    {
        return $this->modelInstance->getTable();
    }

    private function builderQuery(): string
    {
        return "SELECT * FROM {$this->getTable()}{$this->getWhereQuery()}{$this->getOrderBy()}";
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        $this->setQuery($this->builderQuery());
        return $this->run();
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $this->setQuery("select * from {$this->getTable()} where {$this->modelInstance->getPrimaryKey()}=:id");
        $this->setBindArray([$this->modelInstance->getPrimaryKey() => $id]);

        return $this->fetch();
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function findOrFail($id)
    {
        return $this->find($id) ?: die(view(404));
    }

    /**
     * @return Collection
     */
    private function run(): Collection
    {
        echo $this->getQuery();
        $result = $this->fetchAll();

        if ($this->modelInstance->getHidden()) {
            $this->unsetHiddenPropertiesFromArray($result);
        }
        return new Collection($result);
    }


    /**
     * @param object $model
     * @return object
     */
    private function unsetHiddenProperties(object $model): object
    {
        foreach ($this->getModelInstance()->getHidden() as $hidden) {
            unset($model->$hidden);
        }
        return $model;
    }

    /**
     * @param $result
     */
    private function unsetHiddenPropertiesFromArray($result): void
    {
        $hidden = $this->modelInstance->getHidden();
        array_map(static function ($object) use ($hidden) {
            if ($hidden) {
                foreach ($hidden as $property) {
                    unset($object->$property);
                }
            }
        }, $result);
    }

    /**
     * @param string $column
     * @return $this
     */
    public function orderByAsc(string $column = 'id'): self
    {
        $this->setOrderBy(" ORDER BY $column ASC ");
        return $this;
    }

    /**
     * @param string $column
     * @return $this
     */
    public function orderByDesc(string $column = 'id'): self
    {
        $this->setOrderBy(" ORDER BY $column DESC ");
        return $this;
    }

    /**
     * @param mixed $query
     * @return BuilderQuery
     */
    private function setQuery($query): BuilderQuery
    {
        $this->query = $query;
        return $this;
    }


    public function first(): object
    {
        $this->setQuery($this->builderQuery());
        return $this->unsetHiddenProperties($this->fetch());
    }

    public function last()
    {

    }

    /**
     * @return mixed
     */
    private function getQuery()
    {
        return $this->query;
    }


    public function save()
    {
        return get_object_vars($this->modelInstance);
    }


    /**
     * @return FetchStatement
     */
    private function builderFetchStatement(): FetchStatement
    {
        return (new FetchStatement())
            ->setBuilderQuery($this)
            ->setModelClass($this->modelInstance->getTable())
            ->setPdo($this->pdo)
            ->setModelClass($this->modelInstance->getStaticClass())
            ->setQuery($this->getQuery())
            ->setBindArray($this->getBindArray());
    }

    /**
     * @return object|null
     */
    public function fetch()
    {
        return $this->builderFetchStatement()->fetch();
    }

    /**
     * @return array|null
     */
    public function fetchAll(): ?array
    {
        return $this->builderFetchStatement()->fetchAll();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $name = sprintf('scope%s', ucfirst($name));
        if (method_exists($this->modelInstance, $name)) {
            return $this->modelInstance->$name($this);
        }
        return $this;
    }

    /**
     * @return bool
     */
    private function isWhereUsed(): bool
    {
        return $this->isWhereUsed;
    }

    /**
     * @return string
     */
    public function getWhereQuery(): ?string
    {
        return $this->whereQuery;
    }
}
