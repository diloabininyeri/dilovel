<?php


namespace App\Application\Controllers;

use App\Application\Models\Role;
use App\Application\Models\Users;
use App\Components\Database\BuilderQuery;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        Users::has('book')->avg('id');
        Users::has('book')->max('id');
        Users::has('book')->min('id');
        //Users::has('book')->delete();
        //Users::has('book')->update(['name'=>'dilo']);

        Users::has('book')->firstOr(fn () =>'optiona closure');
        Users::has('book')->first();
        Users::has('book')->firstOrFail();
        Users::has('book')->get();

        return Users::when($request->has('id'), fn ($query) =>$query->where('id', $request->get('id')))->get();
    }
}
