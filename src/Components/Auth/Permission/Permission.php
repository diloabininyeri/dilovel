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
     * @param string $permission
     * @return object|null
     */
    public function create(string $permission): ?object
    {
        if ($this->findByName($permission)) {
            return $this->findByName($permission);
        }
        $pdo = $this->getPdoConnection();
        $query = $pdo->prepare('INSERT INTO permissions SET name=:name,created_at=:created_at,updated_at=:updated_at');
        $execute = $query->execute([
            ':name' => $permission,
            ':created_at' => now(),
            ':updated_at' => now()
        ]);
        if ($execute && $query->rowCount()) {
            return (object)['name' => $permission, 'id' => $pdo->lastInsertId()];
        }
        return null;
    }


    /**
     * @param string $permission
     * @return object
     */
    public function findByName(string $permission): ?object
    {
        $query = $this->getPdoConnection()->prepare('SELECT * FROM permissions WHERE name=:name');
        $query->execute(['name' => $permission]);
        $result = $query->fetch(PDO::FETCH_OBJ);
        if ($result) {
            return $result;
        }
        return null;
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function exists(string $permission):bool
    {
        return (bool)$this->findByName($permission);
    }

    /**
     * @param string $oldName
     * @param string $newName
     * @return bool
     */
    public function updateName(string $oldName, string $newName):bool
    {
        $query=$this->getPdoConnection()->prepare('UPDATE roles SET name=:new_name WHERE  name=:name ');
        $execute=$query->execute([':name'=>$oldName,':new_name'=>$newName]);
        return ($execute && $query->rowCount());
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
     * @param string $permission
     * @return bool
     */
    public function delete(string $permission):bool
    {
        $query = $this->getPdoConnection()->prepare('DELETE FROM permissions WHERE name=:name');
        $execute = $query->execute([':name' => $permission]);
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
