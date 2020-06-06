<?php

namespace App\Components\Database;


use Exception;
use RuntimeException;

/**
 * Class PDO
 * @package App\Components\Database
 */
class PDO
{


    /**
     * @param string $name
     * @return \PDO
     * @throws Exception
     */
    public static function connection(string $name): \PDO
    {

        $configArray=get_config_array('pdo')[$name] ?? null;
        if($configArray!==null) {
            return Connection::make(get_config_array('pdo')[$name])->pdo();
        }
        throw new RuntimeException("$name config not found in config/pdo.php");
    }
}