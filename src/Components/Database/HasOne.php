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
    private $mainModelKey;
    /**
     * @var Model
     */
    private Model $mainModelInstance;

    /**
     * HasOne constructor.
     * @param $relationModelClass
     * @param $foreignKey
     * @param $key
     * @param $mainModelInstance
     */
    public function __construct($relationModelClass, $foreignKey, $key, $mainModelInstance)
    {
        $this->relationModelClass = $relationModelClass;
        $this->foreignKey = $foreignKey;
        $this->mainModelKey = $key;
        $this->mainModelInstance = $mainModelInstance;
    }

    /**
     * @return HasOneBuilder
     */
    public function oneToOne(): HasOneBuilder
    {
        $id = $this->mainModelInstance->getPrimaryKeyValue();
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


        $pdo = $this->mainModelInstance->pdoConnection();

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue($this->foreignKey, $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->relationModelClass);
        $stmt->execute();
        $relationObject= $stmt->fetch();

        foreach ($hidden as $item) {
            unset($relationObject->$item);
        }

        return  new HasOneBuilder(
            $relationObject ?:$relationModelInstance ,
            $relationModelInstance,
            $this->mainModelInstance,
            $this->mainModelInstance->pdoConnection(),
            $this->foreignKey
        );
    }
}
