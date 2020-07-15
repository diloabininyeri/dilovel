<?php


namespace App\Components\Database\Relation;

use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\Database\Custom\Db;
use App\Components\Database\Model;
use App\Interfaces\RelationInterface;

/**
 * Class BelongsToMany
 * @package App\Components\Database\Relation
 * @mixin BuilderQuery
 */
class BelongsToMany implements RelationInterface
{
    /**
     * @var BuilderQuery
     */
    private BuilderQuery $builderQuery;

    /**
     * @var string
     */
    private string $relationForeignKey;

    /**
     * @var string
     */
    private string $foreignKey;

    /**
     * @var string
     */
    private string $table;


    /**
     * @var Model
     */
    private ?Model $model = null;


    /**
     * @var Model|mixed
     */
    private Model $relationClassInstance;

    /**
     * BelongsToMany constructor.
     * @param string $relationClass
     */
    public function __construct(string $relationClass)
    {
        $this->relationClassInstance = new $relationClass;
        $this->builderQuery = new BuilderQuery($this->relationClassInstance);
    }

    /**
     * @param array $records
     * @param string $relationName
     * @return array
     */
    public function getWithRelation(array $records, string $relationName): array
    {
        if (empty($records)) {
            return  $records;
        }
        array_map(fn ($i) =>$i->$relationName=[], $records);
        $getAllManyToManyData = $this->getAllRelationData($records);  //user has user_roles

        $manyToManyIds = $getAllManyToManyData->column($this->foreignKey); //just role_id of user_roles
        $manyRelationData=$this->builderQuery->whereIn($this->relationClassInstance->getPrimaryKey(), $manyToManyIds)->get(); //roles

        foreach ($records as $record) {
            $this->pairRelation($record, $relationName, $manyRelationData, $getAllManyToManyData);
        }

        return $records;
    }

    /**
     * @param Model $record
     * @param $relationName
     * @param $manyRelationData
     * @param $getAllManyToManyData
     */
    private function pairRelation(Model $record, $relationName, $manyRelationData, $getAllManyToManyData):void
    {
        foreach ($manyRelationData as $manyRelationDatum) {
            foreach ($getAllManyToManyData as $getAllManyToManyDatum) {
                if (((int)$getAllManyToManyDatum->{$this->foreignKey} === (int)$manyRelationDatum->id) && $record->{$record->getPrimaryKey()} === $getAllManyToManyDatum->{$this->relationForeignKey}) {
                    $record->$relationName[] = $manyRelationDatum;
                }
            }
        }
    }


    /**
     * @param array $records
     * @return Collection
     */
    private function getAllRelationData(array $records): Collection
    {
        $modelIds = array_map(fn ($item) => $item->{$this->getModel()->getPrimaryKey()}, $records);
        return $this->getManyToManyRelationDataBySql($modelIds);
    }


    /**
     * @param array $ids
     * @return Collection
     */
    private function getManyToManyRelationDataBySql(array $ids): Collection
    {
        $quizMark = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM $this->table WHERE $this->relationForeignKey IN($quizMark)";
        return Db::select($sql, $ids);
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
     * @param string $table
     * @return BelongsToMany
     */
    public function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $foreignKey
     * @return BelongsToMany
     */
    public function setForeignKey(string $foreignKey): self
    {
        $this->foreignKey = $foreignKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getForeignKey(): string
    {
        return $this->foreignKey;
    }

    /**
     * @param string $relationForeignKey
     * @return BelongsToMany
     */
    public function setRelationForeignKey(string $relationForeignKey): self
    {
        $this->relationForeignKey = $relationForeignKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getRelationForeignKey(): string
    {
        return $this->relationForeignKey;
    }

    /**
     * @return $this
     */
    public function build(): self
    {
        if ($this->getModel()->isPrimaryKeyHasValue()) {
            $this->builderQuery->whereIn($this->getModel()->getPrimaryKey(), $this->getIds());
        }
        return $this;
    }

    /**
     * @return array
     */
    private function getIds(): array
    {
        $sql = "SELECT * FROM $this->table WHERE $this->relationForeignKey IN(?)";
        return Db::select($sql, [$this->getModel()->getPrimaryKeyValue()])->column($this->foreignKey);
    }

    /**
     * @param Model $model
     * @return BelongsToMany
     */
    public function setModel(Model $model): BelongsToMany
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
