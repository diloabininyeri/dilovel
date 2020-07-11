<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Auth\Permission\Permission;
use App\Components\Auth\Permission\PermissionMapperObject;
use App\Components\Auth\Permission\Role;
use App\Components\Database\Custom\Db;
use App\Components\Http\Request;
use PDO;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class TestWithOrm
{
    public function index(Request $request)
    {
        return Users::with('book', 'role')->get();
    }

}
