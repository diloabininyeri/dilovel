<?php


namespace App\Components\Database\Relation;

use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;

/**
 * Class HasOne
 * @package App\Models
 * @mixin BuilderQuery
 */
class HasOne
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
     * HasOne constructor.
     * @param string $relationClass
     */
    public function __construct(string $relationClass)
    {
        $this->buildQuery = new BuilderQuery(new $relationClass);
    }

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
     * @param Collection $model
     * @param int $primaryKey
     * @return Model|null
     */
    private function findHasRelation(Collection $model, int $primaryKey): ?Model
    {
        foreach ($model as $item) {
            if ((int)$item->{$this->foreignKey} === $primaryKey) {
                return $item;
            }
        }
        return null;
    }
    /**
     * @param array $records
     * @param string $relation
     * @return array
     */
    public function getWithRelation(array $records, string $relation): array
    {
        $primaryKey = $this->primaryKey;
        $primaryKeyValues = array_map(static function ($item) use ($primaryKey) {
            return $item->$primaryKey;
        }, $records);


        $relationData = $this->getWithWhereIn($primaryKeyValues);
        foreach ($records as $record) {
            $record->$relation = $this->findHasRelation($relationData, $record->{$this->primaryKey});
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
     * @return HasOne
     */
    public function setForeignKey(string $foreignKey): self
    {
        $this->foreignKey = $foreignKey;
        return $this;
    }

    /**
     * @param array $columns
     * @return object|null
     */
    public function get(...$columns)
    {
        return $this->buildQuery->first($columns);
    }

    /**
     * @param string $primaryKey
     * @return HasOne
     */
    public function setPrimaryKey(string $primaryKey): self
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }

    /**
     * @param Model $model
     * @return HasOne
     */
    public function setModel(Model $model): HasOne
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
