<?php


namespace App\Interfaces;

use App\Application\Models\Users;

interface AuthEventListener
{
    /**
     * @param Users $user
     * @return mixed
     */
    public function handle(Users $user):void ;
}
