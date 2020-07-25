<?php


namespace App\Components\Database\Custom;

use App\Components\Cache;
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
     * @var bool
     */
    private bool $withCache=false;

    /**
     * @var int
     */
    private int  $cacheTime=0;

    /**
     * DbQuery constructor.
     * @param PDO $pdoConnection
     */
    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if ($name === 'withCache') {
            $this->withCache=true;
            $this->cacheTime=$arguments[0] ?? 120;
        }
        if ($name === 'withoutCache') {
            $this->withCache=false;
        }
        return $this;
    }

    private function createKeyHash(string $query, array $bind=[], string $mapperClass=null):string
    {
        $key=$query.implode($bind).$mapperClass;
        return md5($key);
    }

    private function selectWithCache(string $query, array $bind=[], string $mapperClass=null):Collection
    {
        $hashKey=$this->createKeyHash($query, $bind, $mapperClass);
        return Cache::remember($hashKey, function () use ($bind,$query,$mapperClass) {
            $statement=$this->pdoConnection->prepare($query);
            $statement->execute($bind);
            if ($mapperClass) {
                return new Collection($statement->fetchAll(PDO::FETCH_CLASS, $mapperClass));
            }
            return new Collection($statement->fetchAll(PDO::FETCH_OBJ));
        }, $this->cacheTime);
    }

    /**
     * @param string $query
     * @param array $bind
     * @param string|null $mapperClass
     * @return Collection
     */
    public function select(string $query, array $bind=[], string $mapperClass=null):Collection
    {
        if ($this->cacheTime) {
            return $this->selectWithCache($query, $bind, $mapperClass);
        }

        $statement=$this->pdoConnection->prepare($query);
        $statement->execute($bind);
        if ($mapperClass) {
            return new Collection($statement->fetchAll(PDO::FETCH_CLASS, $mapperClass));
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
