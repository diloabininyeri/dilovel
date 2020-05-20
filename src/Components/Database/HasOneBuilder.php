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
     * @var PDO
     */
    private PDO $pdoConnection;

    /**
     * @var Model
     */
    private Model $relationModelInstance;

    /**
     * HasOneBuilder constructor.
     * @param Model $model
     * @param Model $relationModelInstance
     * @param PDO $pdoConnection
     */
    public function __construct(Model $model, Model $relationModelInstance, PDO $pdoConnection)
    {

        $this->model = $model;
        $this->pdoConnection = $pdoConnection;
        $this->relationModelInstance = $relationModelInstance;
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
        $table = $this->relationModelInstance->getTable();
        $primaryKey = $this->model->getPrimaryKey();
        $deleteQuery = $this->pdoConnection->prepare("DELETE FROM {$table} WHERE $primaryKey=:primary_key");
        return $deleteQuery->execute([':primary_key' => $this->model->getPrimaryKeyValue()]);
    }

    /**
     * @param array $data
     * @return object|null
     */
    public function update(array $data): ?object
    {
        if (!$this->model->getPrimaryKeyValue()) {
            return null;
        }

        $updateQuery=null;
        $bindArray=[];
        foreach (  $data as $key=>$value) {

            $updateQuery.="$key=:update_$key,";
            $bindArray[":update_$key"]=$value;

        }

        $bindArray[':primary_key'] = $this->model->getPrimaryKeyValue();
        $updateQuery=rtrim($updateQuery,',');
        $table = $this->relationModelInstance->getTable();
        $primaryKey = $this->model->getPrimaryKey();

        $deleteQuery = $this->pdoConnection->prepare("UPDATE  {$table} SET $updateQuery  WHERE $primaryKey=:primary_key");
        if( $deleteQuery->execute($bindArray)) {
            return $this->find();
        }

        return null;

    }

    /**
     * @return object
     */
    private function find():object
    {
        return (new BuilderQuery($this->relationModelInstance,$this->pdoConnection))->find($this->model->getPrimaryKeyValue());
    }

    /**
     * @return object
     */
    public function create(): object
    {

    }

    /**
     * @return Model|null
     */
    private function getModel(): ?Model
    {
        return $this->model;
    }
}
