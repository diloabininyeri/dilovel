<?php


namespace App\Components\Database\Relation;

use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;
use App\Interfaces\HasRelationInterface;
use App\Interfaces\RelationInterface;

/**
 * Class HasOne
 * @package App\Models
 * @mixin BuilderQuery
 */
class HasOne implements RelationInterface, HasRelationInterface
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
    private BuilderQuery $builderQuery;


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
        $this->builderQuery = new BuilderQuery(new $relationClass);
    }

    public function withDefault(array $default):self
    {
        $this->withDefault=$default;
        return $this;
    }

    /**
     * @param array $records
     * @return array
     */
    private function setDefaultAttribute(array $records):array
    {
        if (empty($this->withDefault)) {
            return $records;
        }
        array_walk($records, function ($item) {
            foreach ($this->withDefault as $key => $value) {
                if ($item->$key === null) {
                    $item->$key = $value;
                }
            }
        });
        return $records;
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
        if (empty($records)) {
            return  $records;
        }
        $primaryKey = $this->primaryKey;
        $primaryKeyValues = array_map(static function ($item) use ($primaryKey) {
            return $item->$primaryKey;
        }, $records);


        $relationData = $this->getWithWhereIn($primaryKeyValues);
        foreach ($records as $record) {
            $record->$relation = $this->findHasRelation($relationData, $record->{$this->primaryKey});
        }

        return $this->setDefaultAttribute($records);
    }

    /**
     * @param array $primaryKeyValues
     * @return Collection
     */
    private function getWithWhereIn(array $primaryKeyValues): Collection
    {
        return $this->builderQuery->whereIn($this->foreignKey, $primaryKeyValues)->get();
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
        return $this->builderQuery->first(...$columns);
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
     * for example Users::has('book')->get();
     * @param BuilderQuery $builderQuery
     * @return BuilderQuery
     */
    public function setHasExistQuery(BuilderQuery $builderQuery):BuilderQuery
    {
        return  (new HasOneExistsRelation($this))->setHasExistQuery($builderQuery);
    }
    /**
     * @return $this
     */
    public function build(): self
    {
        if ($this->model->isPrimaryKeyHasValue()) {
            $this->builderQuery->where($this->foreignKey, $this->model->getPrimaryKeyValue());
        }
        return $this;
    }

    /**
     * @return BuilderQuery
     */
    public function getBuilderQuery(): BuilderQuery
    {
        return $this->builderQuery;
    }

    /**
     * @return string
     */
    public function getForeignKey(): string
    {
        return $this->foreignKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }
}
