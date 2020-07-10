<?php


namespace App\Components\Database\Custom;

use App\Components\Collection\Collection;
use PDO;

/**
 * Class DbQuery
 * @package App\Components\Database\Custom
 */
class DbQuery
{
    /**
     * @var PDO
     */
    private PDO $pdoConnection;

    /**
     * DbQuery constructor.
     * @param PDO $pdoConnection
     */
    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }


    /**
     * @param string $query
     * @param array $bind
     * @param string|null $mapperClass
     * @return Collection
     */
    public function select(string $query, array $bind=[], string $mapperClass=null):Collection
    {
        $statement=$this->pdoConnection->prepare($query);
        $statement->execute($bind);
        if ($mapperClass) {
            return new Collection($statement->fetchAll(PDO::FETCH_CLASS,$mapperClass));
        }
        return new Collection($statement->fetchAll(PDO::FETCH_OBJ));
    }

    /**
     * @param string $query
     * @param array $bind
     * @return bool
     */
    public function query(string $query, array $bind=[]):bool
    {
        $statement=$this->pdoConnection->prepare($query);
        return ($statement->execute($bind) && $statement->rowCount());
    }
}
