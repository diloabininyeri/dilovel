<?php


namespace App\Components\Database;

use PDO;

/**
 * Class HasOne
 * @package App\Models
 */
class HasOne
{

    /**
     * @var
     */
    private $model;
    /**
     * @var
     */
    private int $foreignKey;
    /**
     * @var
     */
    private $key;
    /**
     * @var Model
     */
    private Model $modelInstance;

    /**
     * HasOne constructor.
     * @param $model
     * @param $foreignKey
     * @param $key
     * @param $modelInstance
     */
    public function __construct($model, $foreignKey, $key, $modelInstance)
    {

        $this->model = $model;
        $this->foreignKey = $foreignKey;
        $this->key = $key;
        $this->modelInstance = $modelInstance;
    }

    /**
     * @return mixed
     */
    public function oneToOne()
    {

        $id = $this->modelInstance->id;
        $model = $this->model;
        $relationModelInstance=new $model();
        $relationTable =$relationModelInstance->getTable();
        $hidden=$relationModelInstance->getHidden();
        $sql = sprintf(
            'select * from %s where %s=:%s',
            $relationTable,
            $this->foreignKey,
            $this->foreignKey);

        $pdo = $this->modelInstance->pdoConnection();

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue($this->foreignKey, $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->model);
        $stmt->execute();
        $result= $stmt->fetch();

        foreach ($hidden as $item) {

                unset($result->$item);
        }

        return $result;



    }
}