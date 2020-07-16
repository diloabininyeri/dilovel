<?php


namespace App\Application\Controllers;

use App\Application\Models\Role;
use App\Application\Models\Users;
use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\File\Excel;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {

       // return Users::where('id',600,'<')->max('id');

        // return Users::has('book')->avg('id');

        $users=  Users::whereHour('created_at', 25)->get('id', 'name');


        return $users;



        return ;

        // return  Users::with('book')->selectRaw('select * from users where id=:id',['id'=>100]);
        //return  Users::with('roles')->where('id',100)->get();
        /*  Users::has('book')->avg('id');
          Users::has('book')->max('id');
          Users::has('book')->min('id');
          //Users::has('book')->delete();
          //Users::has('book')->update(['name'=>'dilo']);

          Users::has('book')->firstOr(fn () =>'optiona closure');
          Users::has('book')->first();
          Users::has('book')->firstOrFail();*/
        // return  Users::has('book')->regexp('name', '[a-z]')->orderByDesc()->get();
        return  Users::has('book')->between('id', 0, 30)->limit(21)->orderByDesc()->get();
    }
}
