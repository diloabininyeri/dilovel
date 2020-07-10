<?php


namespace App\Components\Auth\Permission;

use App\Components\Database\PDOAdaptor;
use PDO;

/**
 * Class Role
 * @package App\Components\Auth\Permission
 */
class Role
{
    /**
     * @var string
     */
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
        $query = $pdo->prepare('INSERT INTO roles SET name=:name,created_at=:created_at,updated_at=:updated_at');
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
     * @return RoleMapperObject
     */
    public function findByName(string $roleName): ?RoleMapperObject
    {
        $query = $this->getPdoConnection()->prepare('SELECT * FROM roles WHERE name=:name');
        $query->setFetchMode(PDO::FETCH_CLASS, RoleMapperObject::class, [$this->getPdoConnection()]);
        $query->execute(['name' => $roleName]);
        $result = $query->fetch();
        if ($result) {
            return $result;
        }
        return null;
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
    public function getAll(): array
    {
        return $this->getPdoConnection()
            ->query('SELECT * FROM roles')
            ->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function exists(string $roleName): bool
    {
        return (bool)$this->findByName($roleName);
    }


    /**
     * @param string $roleName
     * @return bool
     */
    public function delete(string $roleName): bool
    {
        $findRole=$this->findByName($roleName);
        if ($findRole) {
            $pdo=$this->getPdoConnection();
            $query = $pdo->prepare('DELETE FROM roles WHERE name=:name');
            $execute = $query->execute([':name' => $findRole->name]);
            $isDeleted= ($execute && $query->rowCount());
            $this->deleteRelationData($findRole->id);
            return $isDeleted;
        }
        return  false;
    }

    /**
     * @param string $connectionName
     * @return Role
     */
    public function setConnectionName(string $connectionName): self
    {
        $this->connectionName = $connectionName;
        return $this;
    }


    /**
     * @param int $roleId
     * @return bool
     */
    private function deleteRelationData(int $roleId):bool
    {
        return ($this->deleteRolePermission($roleId)&& $this->deleteUserRole($roleId));
    }
    /**
     * @param $roleId
     * @return bool
     */
    private function deleteRolePermission($roleId):bool
    {
        return  $this->getPdoConnection()
            ->prepare('DELETE FROM role_permissions WHERE role_id=:role_id')
            ->execute(['role_id'=>$roleId]);
    }
    /**
     * @param $roleId
     * @return bool
     */
    private function deleteUserRole($roleId):bool
    {
        return  $this->getPdoConnection()
            ->prepare('DELETE FROM user_roles WHERE role_id=:role_id')
            ->execute(['role_id'=>$roleId]);
    }
}
