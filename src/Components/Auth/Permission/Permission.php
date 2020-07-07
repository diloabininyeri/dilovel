<?php


namespace App\Components\Auth\Permission;

use PDO;
use App\Components\Database\PDOAdaptor;

/**
 * Class Permission
 * @package App\Components\Auth\Permission
 */
class Permission
{
    private string $connectionName = 'default';

    /**
     * @return PDO
     */
    private function getPdoConnection(): PDO
    {
        return PDOAdaptor::connection($this->connectionName);
    }

    /**
     * @param string $roleName
     * @return object|null
     */
    public function create(string $roleName): ?object
    {
        if ($this->findByName($roleName)) {
            return $this->findByName($roleName);
        }
        $pdo = $this->getPdoConnection();
        $query = $pdo->prepare('INSERT INTO permissions SET name=:name,created_at=:created_at,updated_at=:updated_at');
        $execute = $query->execute([
            ':name' => $roleName,
            ':created_at' => now(),
            ':updated_at' => now()
        ]);
        if ($execute && $query->rowCount()) {
            return (object)['name' => $roleName, 'id' => $pdo->lastInsertId()];
        }
        return null;
    }


    /**
     * @param string $roleName
     * @return object
     */
    public function findByName(string $roleName): ?object
    {
        $query = $this->getPdoConnection()->prepare('SELECT * FROM permissions WHERE name=:name');
        $query->execute(['name' => $roleName]);
        $result = $query->fetch(PDO::FETCH_OBJ);
        if ($result) {
            return $result;
        }
        return null;
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function exists(string $roleName):bool
    {
        return (bool)$this->findByName($roleName);
    }

    /**
     * @return array
     */
    public function getAll():array
    {
        return $this->getPdoConnection()
               ->query('SELECT * FROM permissions')
             ->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function delete(string $roleName):bool
    {
        $query = $this->getPdoConnection()->prepare('DELETE FROM permissions WHERE name=:name');
        $execute = $query->execute([':name' => $roleName]);
        return ($execute && $query->rowCount());
    }
    /**
     * @param string $connectionName
     * @return $this
     */
    public function setConnectionName(string $connectionName): self
    {
        $this->connectionName = $connectionName;
        return $this;
    }
}