<?php


namespace App\Application\Controllers;

use App\Application\Models\Book;
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
        return Book::groupBy('user_id')->having('avg', 2, '<=')->first('avg(id) as avg,any_value(id) as id');
    }
}
