<?php


namespace App\Components\Database\Custom;

use App\Components\Collection\Collection;
use App\Components\Database\PDOAdaptor;
use PDO;

/**
 * Class Db
 * @package App\Components\Database\Custom
 * @method static Collection select(string $query, array $bind=[], string $mapperClass=null)
 * @method static bool query(string $query, array $bind=[])
 * @method static DbQuery withCache(int $seconds=120)
 * @method static DbQuery withoutCache()
 */
class Db
{

    /**
     * @param string $name
     * @return PDO
     */
    private static function getPdoConnection(string $name='default'): PDO
    {
        return PDOAdaptor::connection($name);
    }


    /**
     * @param string|null $connectionName
     * @param callable $closure
     * @return DbQuery|mixed
     */
    public static function connection(string $connectionName=null, callable $closure=null)
    {
        if ($connectionName === null) {
            return new DbQuery(self::getPdoConnection('default'));
        }
        if ($connectionName !== null && $closure === null) {
            return new DbQuery(self::getPdoConnection($connectionName), $connectionName);
        }

        return  $closure(PDOAdaptor::connection($connectionName));
    }

    /**
     * @param $name
     * @param $arguments
     * @return DbQuery
     */
    public static function __callStatic($name, $arguments)
    {
        return (new DbQuery(self::getPdoConnection()))->$name(...$arguments);
    }
}
