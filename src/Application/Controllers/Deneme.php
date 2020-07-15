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
        return Excel::export(Users::get()->toArray())
            ->withDefault(['email'=>'email@yok.com'])
            ->setValue('surname','strtoupper')
            ->toHtml();

        // return  Users::with('book')->selectRaw('select * from users where id=:id',['id'=>100]);
        //return  Users::with('roles')->where('id',100)->get();
        Users::has('book')->avg('id');
        Users::has('book')->max('id');
        Users::has('book')->min('id');
        //Users::has('book')->delete();
        //Users::has('book')->update(['name'=>'dilo']);

        Users::has('book')->firstOr(fn () =>'optiona closure');
        Users::has('book')->first();
        Users::has('book')->firstOrFail();
        return  Users::with('book')->get();

        return Users::when($request->has('id'), fn ($query) =>$query->where('id', $request->get('id')))->get();
    }
}
