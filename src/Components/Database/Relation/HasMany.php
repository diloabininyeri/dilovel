<?php


namespace App\Components\Database\Relation;

use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;
use App\Interfaces\RelationInterface;

/**
 * Class HasMany
 * @package App\Components\Database\Relation
 *
 */
class HasMany implements RelationInterface
{
    /**
     * @var string
     */
    private string $foreignKey;
    /**
     * @var string
     */
    private string $primaryKey;
    /**
     * @var Model
     */
    private Model $model;
    /**
     * @var BuilderQuery
     */
    private BuilderQuery $buildQuery;

    /**
     * @var array $withDefault
     */
    private array $withDefault=[];

    /**
     * self constructor.
     * @param string $relationClass
     */
    public function __construct(string $relationClass)
    {
        $this->buildQuery = new BuilderQuery(new $relationClass);
    }

    /**
     * @param array $default
     * @return $this
     * @noinspection PhpUnused
     */
    public function withDefault(array $default):self
    {
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->buildQuery->$name(...$arguments);
    }


    /**
     * @param Collection $relationData
     * @param Model $record
     * @param $relationName
     */
    private function pairRelation(Collection $relationData, Model $record, $relationName): void
    {
        foreach ($relationData as $relationDatum) {
            if ((int)$relationDatum->{$this->foreignKey} === (int)$record->{$this->primaryKey}) {
                $record->$relationName[]=$relationDatum;
            }
        }
    }
    /**
     * @param array $records
     * @param string $relation
     * @return array
     */
    public function getWithRelation(array $records, string $relation): array
    {
        if (empty($records)) {
            return  $records;
        }
        $primaryKeyValues = array_map(function ($item) {
            return $item->{$this->primaryKey};
        }, $records);


        $relationData = $this->getWithWhereIn($primaryKeyValues);
        array_walk($records, fn ($item) =>$item->$relation=[]);


        foreach ($records as $record) {
            $this->pairRelation($relationData, $record, $relation);
        }
        return $records;
    }

    /**
     * @param array $primaryKeyValues
     * @return Collection
     */
    private function getWithWhereIn(array $primaryKeyValues): Collection
    {
        return $this->buildQuery->whereIn($this->foreignKey, $primaryKeyValues)->get();
    }

    /**
     * @param string $foreignKey
     * @return self
     */
    public function setForeignKey(string $foreignKey): self
    {
        $this->foreignKey = $foreignKey;
        return $this;
    }


    /**
     * @return array
     */
    public function delete():array
    {
        $status=[];
        foreach ($this->get() as $item) {
            $status[]=$item->delete();
        }
        return $status;
    }

    /**
     * @param array $data
     * @return array
     */
    public function update(array $data): array
    {
        $status=[];
        foreach ($this->get() as $item) {
            $status[]=$item->update($data);
        }
        return $status;
    }

    /**
     * @param array $columns
     * @return object|null
     */
    public function get(...$columns)
    {
        return $this->buildQuery->get(...$columns);
    }

    /**
     * @param string $primaryKey
     * @return self
     */
    public function setPrimaryKey(string $primaryKey): self
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }

    /**
     * @param Model $model
     * @return self
     */
    public function setModel(Model $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return $this
     */
    public function build(): self
    {
        if ($this->model->isPrimaryKeyHasValue()) {
            $this->buildQuery->where($this->foreignKey, $this->model->getPrimaryKeyValue());
        }
        return $this;
    }
}
