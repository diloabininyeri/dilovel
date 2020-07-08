<?php


namespace App\Components\Auth\Permission;

use PDO;

class RoleMapperObject
{
    private PDO $pdoConnection;

    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    /**
     * @return PDO
     */
    private function getPdoConnection(): PDO
    {
        return $this->pdoConnection;
    }
}
