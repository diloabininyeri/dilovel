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
     * @var string $connectionName
     */
    private string $connectionName;

    /**
     * DbQuery constructor.
     * @param PDO $pdoConnection
     * @param string $connectionName
     */
    public function __construct(PDO $pdoConnection, string $connectionName='default')
    {
        $this->pdoConnection = $pdoConnection;
        $this->connectionName=$connectionName;
    }

    /**
     * @param int $seconds
     * @return $this
     */
    public function withCache(int $seconds=120):self
    {
        $this->cacheTime=$seconds;
        $this->withCache=true;
        return $this;
    }

    /**
     * @return $this
     */
    public function withoutCache():self
    {
        $this->withCache=false;
        return $this;
    }
    /**
     * @param string $query
     * @param array $bind
     * @param string|null $mapperClass
     * @return string
     */
    private function createKeyHash(string $query, array $bind=[], string $mapperClass=null):string
    {
        $key=$this->connectionName.$query.implode($bind).$mapperClass;
        return md5($key);
    }

    /**
     * @param string $query
     * @param array $bind
     * @param string|null $mapperClass
     * @return Collection
     */
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
        if ($this->withCache) {
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
