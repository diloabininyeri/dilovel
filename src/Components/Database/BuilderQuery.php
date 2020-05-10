<?php

namespace App\Components\Database;

use App\Components\Collection\Collection;
use JsonException;
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

    /**
     * @var string|null
     */
    private ?string $query = null;


    /**
     * @var array
     */
    private array $bindArray = [];

    /**
     * @var string|null
     */
    private ?string $orderBy = null;

    /**
     * @var bool
     */
    private bool $isWhereUsed = false;

    /**
     * @var string $whereQuery
     */
    private ?string  $whereQuery = null;

    /**
     * @var bool
     */
    private bool $isSelected = false;

    /**
     * @var
     */
    private $limit;

    /**
     * @var string|null
     */
    private ?string $selectQuery = null;

    /**
     * @var string|null
     */
    private ?string $mixedQuery = null;

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
     * @param mixed ...$columns
     * @return $this
     */
    public function select(...$columns): BuilderQuery
    {
        if (empty($columns)) {
            $star = ['*'];
        }

        $fields = implode(',', $star ?? $columns);
        if (!$this->isSelected()) {
            $this->selectQuery = "SELECT $fields ";
        } else {
            $this->selectQuery = "SELECT $fields " . $this->selectQuery;
        }

        $this->setIsSelected(true);

        return $this;
    }

    /**
     * @param $data
     * @return string
     */
    private function builderUpdateQuery($data): string
    {
        $query = null;
        foreach ($data as $key => $value) {
            $query .= " $key=:update_$key ,";
            $this->bindArray[":update_$key"] = $value;
        }
        $query = rtrim($query, ',');
        return "UPDATE {$this->getTable()}  SET {$query} {$this->mixedQuery} {$this->getWhereQuery()}{$this->getLimit()}";
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        $this->setQuery($this->builderUpdateQuery($data));
        $query = $this->pdo->prepare($this->getQuery());
        return $query->execute($this->bindArray);
    }

    /**
     * @return string
     */
    private function builderDeleteQuery():string
    {
        return "DELETE FROM {$this->getTable()}  {$this->mixedQuery} {$this->getWhereQuery()}{$this->getLimit()}";
    }


    /**
     * @return bool
     */
    public function delete(): bool
    {
        $this->setQuery($this->builderDeleteQuery());
        $query=$this->pdo->prepare($this->getQuery());
        $query->execute($this->bindArray);
        return $query->rowCount();

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

        $this->bindArray[":where_$key"] = $value;
        $this->isWhereUsed = true;
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @param $operator
     * @return object|null
     */
    public function whereFirst($column, $value, $operator)
    {
        $this->where($column, $value, $operator);
        return $this->first();
    }

    /**
     * @param string $column
     * @param array $values
     * @return $this
     */
    public function whereIn(string $column, array $values): self
    {
        $bind = array_fill(0, count($values), '?');
        $bindImplode = implode(',', $bind);
        if ($this->isWhereUsed()) {
            $this->whereQuery .= " AND $column IN ($bindImplode) ";
        } else {
            $this->whereQuery = "WHERE $column IN ($bindImplode)";
        }
        $this->bindArray = $values;
        $this->isWhereUsed = true;
        return $this;
    }

    /**
     * @param string $raw
     * @return $this
     */
    public function whereRaw(string $raw): self
    {
        if ($this->isWhereUsed()) {
            $this->whereQuery .= " AND $raw ";
        } else {
            $this->whereQuery = " WHERE $raw ";
        }
        $this->isWhereUsed = true;
        return $this;
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     * @return $this
     * @noinspection PhpUnused
     */
    public function orWhere($key, $value, $operator = '='): self
    {
        if ($this->isWhereUsed()) {
            $this->whereQuery .= " OR $key$operator:or_where$key";
        } else {
            $this->whereQuery = " WHERE $key$operator:or_where$key ";
        }

        $this->bindArray[":or_where$key"] = $value;
        $this->isWhereUsed = true;
        return $this;
    }


    /**
     * @param string $column
     * @param $smallValue
     * @param $bigValue
     * @param $type @explain between or  not between
     * @return $this
     */
    private function builderBetween(string $column, $smallValue, $bigValue, $type): self
    {
        if ($this->isWhereUsed()) {
            $this->whereQuery .= " AND $column  $type :between_small_value$column AND :between_big_value$column";
        } else {
            $this->whereQuery = " WHERE $column $type $smallValue AND $bigValue ";
        }
        $this->bindArray[":between_small_value$column"] = $smallValue;
        $this->bindArray[":between_big_value$column"] = $bigValue;

        $this->isWhereUsed = true;
        return $this;
    }

    /**
     * @param string $column
     * @param $smallValue
     * @param $bigValue
     * @return $this
     */
    public function between(string $column, $smallValue, $bigValue): self
    {
        return $this->builderBetween($column, $smallValue, $bigValue, 'BETWEEN');
    }

    /**
     * @param string $column
     * @param $smallValue
     * @param $bigValue
     * @return $this
     */
    public function notBetween(string $column, $smallValue, $bigValue): self
    {
        return $this->builderBetween($column, $smallValue, $bigValue, 'NOT BETWEEN');
    }

    /**
     * @return array
     */
    private function getBindArray(): array
    {
        return $this->bindArray;
    }

    /**
     * @return $this
     */
    private function builderCountQuery(): self
    {
        $primaryKey = $this->getModelInstance()->getPrimaryKey();

        if (!$this->isSelected()) {
            $this->selectQuery = "SELECT COUNT($primaryKey) AS count";
        } else {
            $this->selectQuery .= ",COUNT($primaryKey) AS count";
        }
        $this->setIsSelected(true);
        return $this;
    }

    /**
     * @return mixed
     */
    public function count()
    {
        $this->builderCountQuery();
        $this->setQuery($this->selectBuilderQuery('id'));
        return $this->fetch()->count;
    }

    /**
     * @param $column
     * @return $this
     */
    private function builderAvgQuery($column): self
    {
        if (!$this->isSelected()) {
            $this->selectQuery = "SELECT AVG($column) AS avg";
        } else {
            $this->selectQuery .= ",AVG($column) AS avg";
        }
        $this->setIsSelected(true);
        return $this;
    }

    /***
     * @param $column
     * @return mixed
     * @throws JsonException
     */
    public function avg($column)
    {
        $this->builderAvgQuery($column);
        $this->setQuery($this->selectBuilderQuery('id'));
        return json_decode(json_encode($this->fetchAll(), JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param $column
     * @return $this
     */
    private function builderMaxQuery($column): self
    {
        if (!$this->isSelected()) {
            $this->selectQuery = "SELECT MAX($column) AS max";
        } else {
            $this->selectQuery .= ",AVG($column) AS max";
        }
        $this->setIsSelected(true);
        return $this;
    }

    /**
     * @param $column
     * @return mixed
     */
    public function max($column)
    {
        $this->builderMaxQuery($column);
        $this->setQuery($this->selectBuilderQuery('id'));
        return $this->fetch()->max;
    }

    /***
     * @param $column
     * @return $this
     */
    public function builderMinQuery($column)
    {
        if (!$this->isSelected()) {
            $this->selectQuery = "SELECT MIN($column) AS min";
        } else {
            $this->selectQuery .= ",MIN($column) AS min";
        }
        return $this;
    }

    /**
     * @param $column
     * @return mixed
     */
    public function min($column)
    {
        $this->builderMinQuery($column);
        $this->setQuery($this->selectBuilderQuery('id'));
        return $this->fetch()->min;
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

    /**
     * @return mixed|string
     */
    private function getTable()
    {
        return $this->modelInstance->getTable();
    }


    /**
     * @param $columns
     * @return string
     */
    private function selectBuilderQuery($columns): string
    {
        if (empty($this->getSelectQuery())) {
            $columns = implode(',', $columns) ?: '*';
            $this->setSelectQuery("SELECT $columns");
        }
        return "{$this->getSelectQuery()} FROM {$this->getTable()}{$this->mixedQuery} {$this->getWhereQuery()}{$this->getOrderBy()}{$this->getLimit()}";
    }

    /**
     * @param $table
     * @param $firstCause
     * @param $secondCause
     * @param $type
     * @return $this
     */
    private function builderJoinQuery($table, $firstCause, $secondCause, $type): self
    {
        $this->mixedQuery .= " $type $table ON $firstCause=$secondCause ";
        return $this;
    }

    /**
     * @param $table
     * @param $firstCause
     * @param $secondCause
     * @return $this
     */
    public function innerJoin($table, $firstCause, $secondCause): self
    {
        return $this->builderJoinQuery($table, $firstCause, $secondCause, 'INNER JOIN');
    }

    /**
     * @param $table
     * @param $firstCause
     * @param $secondCause
     * @return $this
     *
     */
    public function leftJoin($table, $firstCause, $secondCause): self
    {
        return $this->builderJoinQuery($table, $firstCause, $secondCause, 'LEFT JOIN');
    }


    /**
     * @param $table
     * @param $firstCause
     * @param $secondCause
     * @return $this
     *
     */
    public function rightJoin($table, $firstCause, $secondCause): self
    {
        return $this->builderJoinQuery($table, $firstCause, $secondCause, 'RIGHT JOIN');
    }


    /**
     * @param $table
     * @param $firstCause
     * @param $secondCause
     * @return $this
     *
     */
    public function outerJoin($table, $firstCause, $secondCause): self
    {
        return $this->builderJoinQuery($table, $firstCause, $secondCause, 'OUTER JOIN');
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function get(...$columns): Collection
    {
        $this->setQuery($this->selectBuilderQuery($columns));
        return $this->runSelect();
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
    private function runSelect(): Collection
    {
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


    /**
     * @param array $columns
     * @return object
     */
    public function first(...$columns): ?object
    {
        $this->setQuery($this->selectBuilderQuery($columns));
        if ($this->fetch()) {
            return $this->unsetHiddenProperties($this->fetch());
        }
        return null;
    }

    /**
     * @param mixed ...$columns
     * @return object|void|null
     */
    public function firstOrFail(...$columns)
    {
        return $this->first(...$columns) ?: die(view('404'));
    }

    /**
     * @param array $columns
     * @return object
     */
    public function last(...$columns): ?object
    {
        $this->setOrderBy(" ORDER BY {$this->modelInstance->getPrimaryKey()} DESC ");
        $this->limit(1);
        $this->setQuery($this->selectBuilderQuery($columns));
        if ($this->fetch()) {
            return $this->unsetHiddenProperties($this->fetch());
        }
        return null;
    }

    /**
     * @param mixed ...$columns
     * @return object|void|null
     */
    public function lastOrFail(...$columns)
    {
        return $this->last(...$columns) ?: die(view('404'));
    }

    /**
     * @return mixed
     */
    private function getQuery()
    {
        return $this->query;
    }


    /**
     * @return array
     */
    public function save()
    {
        return get_object_vars($this->modelInstance);
    }


    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @return $this
     */
    public function having($column, $value, $operator = '='): self
    {
        $this->mixedQuery .= " HAVING $column$operator:hawing_$column ";
        $this->bindArray[":hawing_$column"] = $value;
        return $this;
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

    /**
     * @param $limit
     * @param null $end
     * @return $this
     */
    public function limit($limit, $end = null): self
    {
        if ($end === null) {
            $this->limit = " LIMIT $limit ";
        } else {
            $this->limit = " LIMIT $limit,$end ";
        }
        return $this;
    }

    /**
     * @param mixed ...$columns
     * @return $this
     */
    public function groupBy(...$columns): self
    {
        if (!empty($columns)) {
            $c = implode(',', $columns);
            $this->mixedQuery .= " GROUP BY $c ";
        }
        return $this;
    }

    /**
     * @return mixed
     */
    private function getLimit()
    {
        return $this->limit;
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
     * @return string
     */
    private function getSelectQuery(): ?string
    {
        return $this->selectQuery;
    }

    /**
     * @param string $selectQuery
     * @return BuilderQuery
     */
    private function setSelectQuery(string $selectQuery): BuilderQuery
    {
        $this->selectQuery = $selectQuery;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSelected(): bool
    {
        return $this->isSelected;
    }

    /**
     * @param bool $isSelected
     * @return BuilderQuery
     */
    private function setIsSelected(bool $isSelected): BuilderQuery
    {
        $this->isSelected = $isSelected;
        return $this;
    }

    public function lastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }
}
