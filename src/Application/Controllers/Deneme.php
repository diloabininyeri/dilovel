<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Auth\Permission\Permission;
use App\Components\Auth\Permission\Role;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        /* $user = Users::find(18);
         return $user->permission()->has('can_delete');*/


        $permission=new Permission();
        $find= $permission->findByName('can_update');

        if ($find) {
            $find->attachRole('admin');
            return $find->detachRole('admin');
        }
    }
}
