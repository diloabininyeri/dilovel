<?php

namespace App\Components\Database;

use App\Components\Collection\Collection;
use App\Components\Exceptions\MethodNotfoundInModelException;
use App\Components\Traits\ConditionAble;
use Closure;
use PDO;
use function request;

/**
 * Class BuilderQuery
 * @package App\Database
 */
class BuilderQuery
{
    use ConditionAble;
    /**
     * @var Model
     */
    private Model $modelInstance;

    /**
     * @var string|null
     */
    private ?string $query = null;


    private ?PDO $pdoConnection = null;

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
     * @var array $eager
     */
    private array $eager = [];

    /**
     * @var string|null
     */
    private ?string $hasRelation = null;

    /**
     * BuilderQuery constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->modelInstance = $model;
    }

    /**
     * @param string $relation
     * @return $this
     */
    public function has(string $relation): self
    {
        $this->hasRelation = $relation;
        return $this;
    }

    /**
     * @param string ...$relations
     * @return $this
     */
    public function with(string ...$relations): self
    {
        $this->eager[] = $relations;
        return $this;
    }

    /**
     * @return PDO
     */
    private function pdoInstance(): PDO
    {
        if (!$this->pdoConnection) {
            $this->pdoConnection = PDOAdaptor::connection($this->modelInstance->getConnection());
        }
        return $this->pdoConnection;
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
        $data['updated_at'] = now();
        foreach ($data as $key => $value) {
            $query .= " $key=:update_$key ,";
            $this->bindArray[":update_$key"] = $value;
        }
        $query = rtrim($query, ',');
        return "UPDATE {$this->getTable()}  SET {$query} {$this->mixedQuery} {$this->getWhereQuery()}{$this->getLimit()}";
    }


    /**
     *
     */
    private function whereByFind(): void
    {
        if ($this->modelInstance->isPrimaryKeyHasValue()) {
            $this->where($this->modelInstance->getPrimaryKey(), $this->modelInstance->getPrimaryKeyValue());
        }
    }

    /**
     * @param array $data
     * @return bool
     *
     */
    public function update(array $data = []): bool
    {
        $this->whereByFind();
        $this->setQuery($this->builderUpdateQuery($data ?: get_object_vars($this->modelInstance)));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        $query = $this->pdoInstance()->prepare($this->getQuery());
        ObserverFire::updated($this->modelInstance);
        return $query->execute($this->bindArray);
    }

    /**
     * @return string
     */
    private function builderDeleteQuery(): string
    {
        return "DELETE FROM {$this->getTable()}  {$this->mixedQuery} {$this->getWhereQuery()}{$this->getLimit()}";
    }

    /**
     * @param $data
     */
    private function builderCreateQuery($data): void
    {
        $query = null;
        $data = array_merge($data, ['created_at' => now(), 'updated_at' => now()]);
        foreach ($data as $key => $value) {
            $query .= ", $key=:insert_$key ";
            $this->bindArray[":insert_$key"] = $value;
        }
        $query = ltrim($query, ',');
        $this->setQuery("INSERT INTO {$this->getTable()} SET $query");
    }


    /**
     * @param array $data
     * @return bool|mixed|object|null
     */
    public function create(array $data)
    {
        $this->builderCreateQuery($data);
        $sqlQuery = $this->pdoInstance()->prepare($this->getQuery());
        $execute = $sqlQuery->execute($this->bindArray);
        if ($execute) {
            ObserverFire::created($this->find($this->pdoInstance()->lastInsertId()));
            return $this->find($this->pdoInstance()->lastInsertId());
        }
        return $execute;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $this->whereByFind();

        $this->setQuery($this->builderDeleteQuery());
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        $query = $this->pdoInstance()->prepare($this->getQuery());
        $query->execute($this->bindArray);
        $rowCount = $query->rowCount();
        if ($rowCount) {
            ObserverFire::deleted($this->modelInstance);
        }
        return $rowCount;
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
     * @param string $key
     * @param $value
     * @return $this
     */
    public function whereNot(string $key, $value): self
    {
        return $this->where($key, $value, '<>');
    }

    /**
     * @param string $key
     * @param string $keyword
     * @param $value
     * @return $this
     */
    private function builderLikeOrRegexp(string $key, string $keyword, $value, $not = null): self
    {
        if ($this->isWhereUsed()) {
            $this->whereQuery .= " AND $key $not  $keyword :$keyword$key ";
        } else {
            $this->whereQuery = " WHERE $key $not $keyword :$keyword$key ";
        }

        $this->bindArray[":$keyword$key"] = $value;
        $this->isWhereUsed = true;
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function like(string $key, $value): self
    {
        return $this->builderLikeOrRegexp($key, 'LIKE', $value);
    }


    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function notLike(string $key, $value): self
    {
        return $this->builderLikeOrRegexp($key, 'LIKE', $value, 'NOT');
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function regexp(string $key, $value): self
    {
        return $this->builderLikeOrRegexp($key, 'REGEXP', $value);
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function notRegexp(string $key, $value): self
    {
        return $this->builderLikeOrRegexp($key, 'REGEXP', $value, 'NOT');
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return $this->pdoInstance()->query("SHOW columns FROM {$this->getTable()}")->fetchAll();
    }

    /**
     * @return array
     */
    public function columnNames(): array
    {
        return array_column($this->columns(), 'Field');
    }


    /**
     * @param array $optional
     * @return $this
     */
    public function filter($optional = []): self
    {
        $columnNames = $this->columnNames();
        $queries = array_merge(request()->url()->query(), $optional);
        foreach ($queries as $key => $value) {
            if (in_array($key, $columnNames, true) && in_array($key, $this->getModelInstance()->getFilterableFields(), true)) {
                $this->where($key, $value);
            }
        }
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @param $operator
     * @return object|null
     */
    public function whereFirst(string $column, $value, $operator)
    {
        $this->where($column, $value, $operator);
        return $this->first();
    }

    /**
     * @param string $column
     * @param $value
     * @param $operator
     * @param Closure $closure
     * @return mixed|object|null
     */
    public function whereFirstOr(string $column, $value, $operator, Closure $closure)
    {
        return $this->whereFirst($column, $value, $operator) ?: $closure($this);
    }

    /**
     * @param $column
     * @param $value
     * @param $operator
     * @param Closure $closure
     * @return object|null
     */
    public function whereLastOr($column, $value, $operator, Closure $closure)
    {
        return $this->whereLast($column, $value, $operator) ?: $closure($this);
    }

    /**
     * @param $column
     * @param $value
     * @param $operator
     * @return object|null
     */
    public function whereLast($column, $value, $operator)
    {
        $this->where($column, $value, $operator)->orderByDesc($this->getModelInstance()->getPrimaryKey());
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

    /**
     * @param string $column
     * @return $this
     */
    private function builderSumQuery(string $column):self
    {
        if (!$this->isSelected()) {
            $this->selectQuery = "SELECT SUM($column) AS sum";
        } else {
            $this->selectQuery .= ",SUM($column) AS sum";
        }
        $this->setIsSelected(true);
        return $this;
    }

    /***
     * @param $column
     * @return mixed
     */
    public function avg($column)
    {
        $this->builderAvgQuery($column);
        $this->setQuery($this->selectBuilderQuery($column));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return  $this->fetch()->avg;
    }

    /**
     * @param string $column
     * @return mixed
     */
    public function sum(string $column)
    {
        $this->builderSumQuery($column);
        $this->setQuery($this->selectBuilderQuery($column));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return  $this->fetch()->sum;
    }

    /**
     * @param string $column
     * @return mixed
     */
    public function variance(string $column)
    {
        $this->builderAggregateQuery('variance', $column);
        $this->setQuery($this->selectBuilderQuery($column));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return  $this->fetch()->variance;
    }

    /**
     * @param string $column
     * @return float
     */
    public function std(string $column)
    {
        $this->builderAggregateQuery('std', $column);
        $this->setQuery($this->selectBuilderQuery($column));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return  $this->fetch()->std;
    }

    /**
     * @param string $aggregate
     * @param string $column
     * @return $this
     */
    private function builderAggregateQuery(string $aggregate, string $column):self
    {
        $aggregateUpper=strtoupper($aggregate);
        $aggregateLower=strtolower($aggregate);
        if (!$this->isSelected()) {
            $this->selectQuery = "SELECT $aggregateUpper($column) AS $aggregateLower";
        } else {
            $this->selectQuery .= ",$aggregateUpper($column) AS $aggregateLower";
        }
        $this->setIsSelected(true);
        return $this;
    }

    /**
     * @param string $column
     * @return mixed
     * @throws \JsonException
     */
    public function pluck(string $column)
    {
        $this->builderAggregateQuery('JSON_ARRAYAGG', $column);
        $this->setQuery($this->selectBuilderQuery($column));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return json_decode($this->fetch()->json_arrayagg, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param $columns
     * @return mixed
     */
    public function rest($columns)
    {
        $this->builderAggregateQuery('JSON_OBJECTAGG', $columns);
        $this->setQuery($this->selectBuilderQuery($columns));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return $this->fetch()->json_objectagg;
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
            $this->selectQuery .= ",MAX($column) AS max";
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
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return $this->fetch()->max;
    }

    /***
     * @param $column
     * @return $this
     */
    private function builderMinQuery($column): self
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
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
        return $this->fetch()->min;
    }

    /**
     * @param array $bindArray
     * @return BuilderQuery
     */
    public function setBindArray(array $bindArray): BuilderQuery
    {
        $this->bindArray = $bindArray;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy(): ?string
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
    public function getTable()
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
     * @param array $columns
     * @param Closure $closure
     * @return Collection|mixed
     */
    public function getOr(array $columns, Closure $closure)
    {
        $this->setQuery($this->selectBuilderQuery($columns));
        return $this->runSelect() ?: $closure($this);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $this->setQuery("select * from {$this->getTable()} where {$this->modelInstance->getPrimaryKey()}=:id");
        $this->setBindArray([$this->modelInstance->getPrimaryKey() => $id]);
        $fetch = $this->fetch();
        if ($fetch) {
            ObserveStorage::add($this->modelInstance, clone $fetch);
        }
        return $fetch;
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function findOrFail($id)
    {
        return $this->find($id) ?: die(view('errors.404'));
    }


    /**
     * @param $id
     * @param Closure $closure
     * @return mixed|object|null
     */
    public function findOr($id, Closure $closure)
    {
        return $this->find($id) ?: $closure($this);
    }

    /**
     * @return object|null
     */
    public function prev()
    {
        $self = new self($this->modelInstance);
        return $self->where(
            $this->modelInstance->getPrimaryKey(),
            $this->modelInstance->getPrimaryKeyValue(),
            '<'
        )
            ->orderByDesc($this->modelInstance->getPrimaryKey())
            ->first();
    }

    /**
     * @return object|null
     */
    public function next()
    {
        $self = new self($this->modelInstance);
        return $self->where(
            $this->modelInstance->getPrimaryKey(),
            $this->modelInstance->getPrimaryKeyValue(),
            '>'
        )
            ->first();
    }

    /**
     * @return $this
     */
    private function isHasRelationSetQuery(): self
    {
        if ($this->hasRelation) {
            $this->getModelInstance()->{$this->hasRelation}()->setHasExistQuery($this);
        }
        return $this;
    }

    /**
     * if has relation query change completely query
     * @return $this
     */
    private function setHasRelationQuery():self
    {
        return  $this->getModelInstance()->{$this->hasRelation}()->setHasExistQuery($this);
    }

    /**
     * @return Collection
     */
    private function runSelect(): Collection
    {
        $this->isHasRelationSetQuery();
        $result = $this->fetchAll();

        if ($this->modelInstance->getHidden()) {
            $this->unsetHiddenPropertiesFromArray($result);
        }

        return new Collection($this->crateResultWithRelation($result));
    }

    /**
     * @param array $result
     * @return array
     */
    private function crateResultWithRelation(array $result): array
    {
        if ($eager = $this->getEager()) {
            foreach ($eager as $with) {
                if (method_exists($this->modelInstance, $with)) {
                    $result = $this->modelInstance->$with()->getWithRelation($result, $with);
                } else {
                    throw new MethodNotfoundInModelException("$with method not found in " . get_class($this->modelInstance));
                }
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    private function getEager(): array
    {
        $return = [];
        $array = $this->eager;
        array_walk_recursive($array, static function ($a) use (&$return) {
            $return[] = $a;
        });
        return $return;
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
    public function setQuery($query): BuilderQuery
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
        $this->isHasRelationSetQuery();
        $this->setQuery($this->selectBuilderQuery($columns));
        if ($this->hasRelation) {
            $this->setHasRelationQuery();
        }
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
        return $this->first(...$columns) ?: die(view('errors.404'));
    }

    /**
     * @param Closure $closure
     * @return mixed|object|null
     */
    public function firstOr(Closure $closure)
    {
        return $this->first() ?: $closure();
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
        return $this->last(...$columns) ?: die(view('errors.404'));
    }

    /**
     * @param Closure $closure
     * @return mixed|object|null
     */
    public function lastOr(Closure $closure)
    {
        return $this->last() ?: $closure($this);
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return object
     *
     */
    public function save(): object
    {
        if ($this->modelInstance->isPrimaryKeyHasValue()) {
            $execute = $this->update(get_object_vars($this->getModelInstance()));
            if ($execute) {
                return $this->find($this->getModelInstance()->getPrimaryKeyValue());
            }
        }
        return $this->create(get_object_vars($this->getModelInstance()));
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
            ->setPdo($this->pdoInstance())
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
    public function isWhereUsed(): bool
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
    public function getLimit()
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
        if (stripos($name, 'findBy') === 0) {
            $column = substr($name, 6, strlen($name));
            if (!empty($column)) {
                return $this->where(pascal_to_snake($column), $arguments[0] ?? null)->first();
            }
        }
        $name = sprintf('scope%s', ucfirst($name));
        if (method_exists($this->modelInstance, $name)) {
            return $this->modelInstance->$name($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSelectQuery(): ?string
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
     * @param int $perPage
     * @return Paginate
     */
    public function paginate(int $perPage): Paginate
    {
        $that = clone $this;
        $count = $that->count();
        $start = request()->get('page') ?: 1;
        $this->limit(($start - 1) * $perPage, $perPage);
        $data = $this->get();
        return new Paginate($data, $count, $perPage);
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

    /**
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->pdoInstance()->lastInsertId();
    }


    /**
     * @param mixed ...$columns
     * @return mixed|string|null
     */
    public function getSqlQuery(...$columns)
    {
        $this->setQuery($this->selectBuilderQuery($columns));
        return $this->getQuery();
    }

    /**
     * @return mixed|string|null
     */
    public function deleteSqlQuery()
    {
        $this->setQuery($this->builderDeleteQuery());
        return $this->getQuery();
    }

    /**
     * @param array $data
     * @return mixed|string|null
     */
    public function updateSqlQuery(array $data)
    {
        $this->setQuery($this->builderUpdateQuery($data ?: get_object_vars($this->modelInstance)));
        return $this->getQuery();
    }

    /**
     * @param string $query
     * @param array $bind
     * @return Collection
     */
    public function selectRaw(string $query, array $bind = []): Collection
    {
        $this->setQuery($query);
        $this->bindArray = $bind;
        return $this->runSelect();
    }

    /**
     * @param string $query
     * @param array $bind
     * @return bool
     */
    public function rawQuery(string $query, array $bind): bool
    {
        $this->setQuery($query);
        $statement = $this->pdoInstance()->prepare($this->getQuery());
        return $statement->execute($bind);
    }

    /**
     * @return string|null
     */
    public function getMixedQuery(): ?string
    {
        return $this->mixedQuery;
    }
}
