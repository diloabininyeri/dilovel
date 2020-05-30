<?php


namespace App\Interfaces;

use App\Application\Models\Users;
use App\Components\Database\Model;

/**
 * Interface PolicyInterface
 * @package App\Interfaces
 */
interface PolicyInterface
{

    /**
     * @param Users $user
     * @param Model $model
     * @return mixed
     */
    public function view(Users $user, Model $model):?bool ;

    /**
     * @param Users $user
     * @param Model $model
     * @return mixed
     */
    public function create(Users $user, Model $model):?bool ;

    /**
     * @param Users $user
     * @param Model $model
     * @return mixed
     */
    public function delete(Users $user, Model $model):?bool ;

    /**
     * @param Users $user
     * @param Model $model
     * @return mixed
     */
    public function update(Users $user, Model $model):?bool ;
}
