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
     * @var string $message
     */
    private static string $message='%s index not found in src/config/pdo.php';


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

        throw new RuntimeException(sprintf(self::$message,$name));
    }
}