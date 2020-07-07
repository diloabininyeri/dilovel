<?php


namespace App\Components\Auth\Permission;

use App\Components\Database\Model;
use App\Components\Database\PDOAdaptor;
use App\Components\Exceptions\PermissionNotFoundException;
use PDO;

/**
 * Class UserPermission
 * @package App\Components\Auth\Permission
 */
class UserPermission
{
    /**
     * @var Model
     */
    private Model $userModel;

    /**
     * UserPermission constructor.
     * @param Model $userModel
     */
    public function __construct(Model $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $query = $this->getPdoConnection()->prepare('SELECT * FROM permissions WHERE id IN(SELECT permission_id FROM user_permissions WHERE user_id=:user_id) ');
        $query->execute(['user_id' => $this->getUserId()]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function has(string $permission): bool
    {
        foreach ($this->getAll() as $item) {
            if ($item->name === $permission) {
                return true;
            }
        }
        return false;
    }


    /**
     * @return int
     */
    private function getUserId(): int
    {
        return $this->userModel->id;
    }

    /**
     * @return PDO
     */
    private function getPdoConnection(): PDO
    {
        return PDOAdaptor::connection($this->userModel->getConnection());
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function assign(string $permission): bool
    {
        $permissionObject = $this->findByName($permission);
        if (!$this->has($permission)) {
            $query = $this->getPdoConnection()->prepare('INSERT INTO user_permissions SET user_id=:user_id,permission_id=:permission_id,created_at=:created_at,updated_at=:updated_at');
            $execute = $query->execute([
                'user_id' => $this->getUserId(),
                'permission_id' => $permissionObject->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return ($execute && $query->rowCount());
        }
        return false;
    }

    /**
     * @param string $permission
     * @return object
     */
    private function findByName(string $permission): object
    {
        $permissionObject = (new Permission())->findByName($permission);
        if ($permissionObject) {
            return $permissionObject;
        }

        throw new PermissionNotFoundException(" there is no such $permission permission");
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function remove(string $permission): bool
    {
        $permissionObject = $this->findByName($permission);
        $query = $this->getPdoConnection()->prepare('DELETE FROM user_permissions WHERE user_id=:user_id AND permission_id=:permission_id');
        $execute = $query->execute(['user_id' => $this->getUserId(), 'permission_id' => $permissionObject->id]);
        return ($query->rowCount() && $execute);
    }

    /**
     * @return bool
     */
    public function removeAll(): bool
    {
        $query = $this->getPdoConnection()->prepare('DELETE FROM user_permissions WHERE user_id=:user_id');
        $execute = $query->execute(['user_id' => $this->getUserId()]);
        return ($query->rowCount() && $execute);
    }
}
