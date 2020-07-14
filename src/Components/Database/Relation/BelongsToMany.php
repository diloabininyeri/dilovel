<?php


namespace App\Components\Database\Relation;

use App\Components\Database\BuilderQuery;
use App\Components\Database\Custom\Db;
use App\Components\Database\Model;

/**
 * Class BelongsToMany
 * @package App\Components\Database\Relation
 * @mixin BuilderQuery
 */
class BelongsToMany
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
    private ?Model $model=null;

    /**
     * BelongsToMany constructor.
     * @param string $relationClass
     */
    public function __construct(string $relationClass)
    {
        $this->builderQuery=new BuilderQuery(new $relationClass);
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
    public function build():self
    {
        if ($this->getModel()->isPrimaryKeyHasValue()) {
            $this->builderQuery->whereIn($this->getModel()->getPrimaryKey(), $this->getIds());
        }
        return $this;
    }

    /**
     * @return array
     */
    private function getIds():array
    {
        $sql="SELECT * FROM $this->table WHERE $this->relationForeignKey IN(?)";
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
