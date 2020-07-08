<?php


namespace App\Components\Auth\Permission;

use PDO;

/**
 * Class RoleMapperObject
 * @package App\Components\Auth\Permission
 * @property-read integer $id
 * @property-read string $name
 */
class RoleMapperObject
{
    /**
     * @var PDO
     */
    private PDO $pdoConnection;

    /**
     * RoleMapperObject constructor.
     * @param PDO $pdoConnection
     */
    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    /**
     * @param string $permissionName
     * @return PermissionMapperObject|null
     */
    private function getPermissionObject(string $permissionName): ?PermissionMapperObject
    {
        return (new Permission())->findByName($permissionName);
    }

    /**
     * @param string $permissionName
     * @return bool
     */
    public function has(string $permissionName): bool
    {
        $permissionObject = $this->getPermissionObject($permissionName);
        if ($permissionObject) {
            $query = $this->getPdoConnection()->prepare('SELECT id FROM role_permissions WHERE role_id=:role_id AND permission_id=:permission_id');
            $execute = $query->execute([
                'role_id' => $this->id,
                'permission_id' => $permissionObject->id
            ]);
            return ($execute && $query->rowCount());
        }
        return false;
    }

    /**
     * @param string $permissionName
     * @return bool
     */
    public function remove(string $permissionName): bool
    {
        $permissionObject = $this->getPermissionObject($permissionName);

        if ($permissionObject) {
            $query = $this->getPdoConnection()->prepare('DELETE FROM role_permissions WHERE role_id=:role_id AND permission_id=:permission_id');
            $execute = $query->execute([
                'role_id' => $this->id,
                'permission_id' => $permissionObject->id
            ]);
            return ($execute && $query->rowCount());
        }
        return false;
    }

    /**
     * @return PDO
     */
    private function getPdoConnection(): PDO
    {
        return $this->pdoConnection;
    }

    /**
     * @param string $permissionName
     * @return bool
     */
    public function givePermission(string $permissionName):bool
    {
        $permissionObject = $this->getPermissionObject($permissionName);

        if ($permissionObject && !$this->has($permissionName)) {
            $query = $this->getPdoConnection()->prepare('INSERT INTO  role_permissions  SET role_id=:role_id ,permission_id=:permission_id,created_at=:created_at,updated_at=:updated_at');
            $execute = $query->execute([
                'role_id' => $this->id,
                'permission_id' => $permissionObject->id,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
            return ($execute && $query->rowCount());
        }
        return false;
    }
}
