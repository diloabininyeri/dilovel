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
    private string $relationModelClass;
    /**
     * @var
     */
    private  $foreignKey;
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
     * @param $relationModelClass
     * @param $foreignKey
     * @param $key
     * @param $modelInstance
     */
    public function __construct($relationModelClass, $foreignKey, $key, $modelInstance)
    {
        $this->relationModelClass = $relationModelClass;
        $this->foreignKey = $foreignKey;
        $this->key = $key;
        $this->modelInstance = $modelInstance;
    }

    /**
     * @return HasOneBuilder
     */
    public function oneToOne(): HasOneBuilder
    {
        $id = $this->modelInstance->getPrimaryKeyValue();
        $model = $this->relationModelClass;
        $relationModelInstance=new $model();
        $relationTable =$relationModelInstance->getTable();
        $hidden=$relationModelInstance->getHidden();


        $sql = sprintf(
            'select * from %s where %s=:%s',
            $relationTable,
            $this->foreignKey,
            $this->foreignKey
        );

        $pdo = $this->modelInstance->pdoConnection();

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue($this->foreignKey, $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->relationModelClass);
        $stmt->execute();
        $result= $stmt->fetch();

        foreach ($hidden as $item) {
            unset($result->$item);
        }

        return  new HasOneBuilder($result ?:$relationModelInstance ,$relationModelInstance,$this->modelInstance->pdoConnection());
    }
}
