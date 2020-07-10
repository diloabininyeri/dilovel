<?php


namespace App\Components\Database\Custom;

use App\Components\Database\PDOAdaptor;
use Closure;
use PDO;

/**
 * Class Db
 * @package App\Components\Database\Custom
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
            return new DbQuery(self::getPdoConnection($connectionName));
        }

        if ($connectionName !== null && $closure !== null) {
            return  $closure(PDOAdaptor::connection($connectionName));
        }
    }
}
