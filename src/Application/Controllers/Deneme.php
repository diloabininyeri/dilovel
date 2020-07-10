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
class Deneme
{
    public function index(Request $request)
    {
        DB::select('s');
        //custom query

        Db::connection('default', new self());

        Db::connection('default', static function (PDO $PDO) {
            return $PDO->query('select * from users limit 10')->fetchAll();
        });

        Db::connection()->select('select * from users', [], Users::class);
        Db::connection()->query('update denemeler set name=?  where id=?  ', ['ergregr',1]);
    }

    public function __invoke(PDO $PDO)
    {
        return $PDO->query('select * from users limit 5')->fetchAll();
    }
}
