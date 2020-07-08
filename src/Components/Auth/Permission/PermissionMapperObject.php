<?php


namespace App\Components\Auth\Permission;

use PDO;

/**
 * Class PermissionMapperObject
 * @package App\Components\Auth\Permission
 * @property-read string $name
 * @property-read integer $id
 */
class PermissionMapperObject
{

    /**
     * @var PDO
     */
    private PDO $pdoConnection;

    /**
     * PermissionMapperObject constructor.
     * @param PDO $pdoConnection
     */
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

    private function getRole(string $roleName)
    {
        return (new Role())->findByName($roleName);
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function detachRole(string $roleName):bool
    {
        $role=$this->getRole($roleName);
        if ($role) {
            $query = $this->getPdoConnection()->prepare('DELETE FROM role_permissions WHERE role_id=:role_id AND permission_id=:permission_id');
            $execute = $query->execute([
                'role_id' => $role->id,
                'permission_id' => $this->id,
            ]);
            return ($execute && $query->rowCount());
        }
        return  false;
    }
    /**
     * @param string $roleName
     * @return bool
     */
    public function attachRole(string $roleName):bool
    {
        $role = $this->getRole($roleName);
        if ($role && !$this->has($roleName)) {
            $query = $this->getPdoConnection()->prepare('INSERT INTO role_permissions SET role_id=:role_id,permission_id=:permission_id,created_at=:created_at,updated_at=:updated_at');
            $execute = $query->execute([
                'role_id' => $role->id,
                'permission_id' => $this->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return ($execute && $query->rowCount());
        }
        return false;
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function has(string $roleName):bool
    {
        $role=$this->getRole($roleName);
        if ($role) {
            $query = $this->getPdoConnection()->prepare('SELECT  id FROM role_permissions WHERE role_id=:role_id AND permission_id=:permission_id');
            $execute = $query->execute([
                'role_id' => $role->id,
                'permission_id' => $this->id,
            ]);
            return ($execute && $query->rowCount());
        }
        return  false;
    }
}
