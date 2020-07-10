<?php

namespace App\Components\Database;

use PDO;

/**
 * Class PDO
 * @package App\Components\Database
 */
class PDOAdaptor
{
    /**
     * @var string $message
     */
    private static string $message='%s index not found in src/config/pdo.php';


    /**
     * @param string $name
     * @return PDO
     */
    public static function connection(string $name='default'): PDO
    {
        $configArray=get_config_array('pdo')[$name] ?? null;
        if ($configArray!==null) {
            return Connection::make($configArray)->pdo();
            //return Connection::make(get_config_array('pdo')[$name])->pdo();
        }

        http_response_code(500);
        die(view('errors.general_error', ['error'=>sprintf(self::$message, $name)]));
    }
}
