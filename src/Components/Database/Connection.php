<?php


namespace App\Components\Database;

use PDO;

/**
 * Class Connector
 * @package App\Database
 */
class Connection
{

    /**
     * @var array $config
     */
    private array $config;

    /**
     * Connector constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param $config
     * @return Connection
     */
    public static function make($config): self
    {
        return new self($config);
    }

    /**
     * @return PDO
     */
    public function pdo(): PDO
    {
        return $this->getPdoInstance();
    }

    /**
     * @return PDO
     */
    private function getPdoInstance(): PDO
    {
        $host = $this->config['host'];
        $user = $this->config['user'];
        $password = $this->config['password'];
        $db = $this->config['database'];
        $driver = $this->config['driver'];

        return new PDO("$driver:host=$host;dbname=$db", $user, $password, $this->options());
    }

    /**
     * @return array
     */
    private function options(): array
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
        ];
    }
}
