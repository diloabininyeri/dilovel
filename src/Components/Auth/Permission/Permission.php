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
            $pdo=$this->getPdoConnection();
            $statement= $pdo->query('SELECT * FROM permissions WHERE id=:id');
            $statement->setFetchMode(PDO::FETCH_CLASS, PermissionMapperObject::class, [$this->getPdoConnection()]);
            $statement->execute([
                'id'=>$pdo->lastInsertId()
            ]);
            return $statement->fetch();
        }
        return null;
    }


    /**
     * @param string $permission
     * @return PermissionMapperObject|null
     */
    public function findByName(string $permission): ?PermissionMapperObject
    {
        $query = $this->getPdoConnection()->prepare('SELECT * FROM permissions WHERE name=:name');
        $query->setFetchMode(PDO::FETCH_CLASS, PermissionMapperObject::class, [$this->getPdoConnection()]);
        $query->execute(['name' => $permission]);
        $result = $query->fetch();
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
     * @return PermissionMapperObject[]
     */
    public function getAll():array
    {
        return $this->getPdoConnection()
               ->query('SELECT * FROM permissions')
             ->fetchAll(PDO::FETCH_CLASS, PermissionMapperObject::class, [$this->getPdoConnection()]);
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function delete(string $permission):bool
    {
        $findPermission = $this->findByName($permission);
        if ($findPermission) {
            $query = $this->getPdoConnection()->prepare('DELETE FROM permissions WHERE name=:name');
            $execute = $query->execute([':name' => $permission]);
            $isDeleted= ($execute && $query->rowCount());
            $this->deleteRelationData($findPermission->id);
            return $isDeleted;
        }
        return  false;
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

    /**
     * @param int $permissionId
     * @return bool
     */
    private function deleteRelationData(int $permissionId):bool
    {
        return (
            $this->deleteUserPermission($permissionId) || $this->deleteRolePermissions($permissionId)
        );
    }

    /**
     * @param int $permissionId
     * @return bool
     */
    private function deleteUserPermission(int  $permissionId):bool
    {
        $query=$this->getPdoConnection()->prepare('DELETE FROM user_permissions WHERE permission_id=:permission_id');
        return ($query->execute(['permission_id'=>$permissionId]) && $query->rowCount());
    }

    /**
     * @param int $permissionId
     * @return bool
     */
    private function deleteRolePermissions(int $permissionId):bool
    {
        $query=$this->getPdoConnection()->prepare('DELETE FROM role_permissions WHERE permission_id=:permission_id');
        return ($query->execute(['permission_id'=>$permissionId]) && $query->rowCount());
    }
}
