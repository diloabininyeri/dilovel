<?php


namespace App\Components\Database;

use PDO;

/**
 * Class HasOneBuilder
 * @package App\Components\Database
 */
class HasOneBuilder
{

    /**
     * @var Model
     */
    private Model $model;
    /**
     * @var PDOAdaptor
     */
    private PDO $pdoConnection;

    /**
     * @var Model
     */
    private Model $relationModelInstance;
    /**
     * @var Model
     */
    private Model $mainModel;


    private string  $foreignKey;

    /**
     * HasOneBuilder constructor.
     * @param Model $model
     * @param Model $relationModelInstance
     * @param Model $mainModel
     * @param PDOAdaptor $pdoConnection
     * @param string $foreignKey
     */
    public function __construct(Model $model, Model $relationModelInstance, Model $mainModel, PDO $pdoConnection, string $foreignKey)
    {
        $this->model = $model;
        $this->pdoConnection = $pdoConnection;
        $this->relationModelInstance = $relationModelInstance;
        $this->mainModel = $mainModel;
        $this->foreignKey = $foreignKey;
    }

    /**
     * @return object
     */
    public function get(): object
    {
        return $this->model ?? (object)[];
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        if (!$this->model->getPrimaryKeyValue()) {
            return false;
        }

        return $this->builderQuery()
            ->where(
                $this->foreignKey,
                $this->mainModel->getPrimaryKeyValue()
            )
            ->delete();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        if (!$this->model->getPrimaryKeyValue()) {
            return false;
        }

        return $this->builderQuery()->where(
            $this->model->getPrimaryKey(),
            $this->model->getPrimaryKeyValue()
        )->update($data);
    }

    private function builderQuery(): BuilderQuery
    {
        return new BuilderQuery($this->relationModelInstance, $this->pdoConnection);
    }
    /**
     * @param array $data
     * @return object
     */
    public function create(array $data): object
    {
        $data[$this->foreignKey]=$this->mainModel->getPrimaryKeyValue();
        return  $this->builderQuery()->create($data);
    }
}
