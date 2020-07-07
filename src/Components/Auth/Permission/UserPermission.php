<?php


namespace App\Components\Auth\Permission;

use App\Components\Database\Model;
use App\Components\Database\PDOAdaptor;
use PDO;

class UserPermission
{
    private Model $userModel;

    public function __construct(Model $userModel)
    {
        $this->userModel=$userModel;
    }

    /**
     * @return array
     */
    public function getAll():array
    {
        $query=$this->getPdoConnection()->prepare('SELECT * FROM permissions WHERE user_id=:user_id');
        $query->execute(['user_id' => $this->getUserId()]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return int
     */
    private function getUserId():int
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
}
