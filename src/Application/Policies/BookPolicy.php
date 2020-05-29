<?php


namespace App\Application\Policies;

use App\Application\Models\Users;
use App\Components\Database\Model;
use App\Interfaces\PolicyInterface;

class BookPolicy implements PolicyInterface
{
    public function view(Users $user, Model $model)
    {
        return $user->id===$model->user_id;
    }

    public function create(Users $user, Model $model)
    {
        // TODO: Implement create() method.
    }

    public function delete(Users $user, Model $model)
    {
        // TODO: Implement delete() method.
    }

    public function update(Users $user, Model $model)
    {
        // TODO: Implement update() method.
    }
}
