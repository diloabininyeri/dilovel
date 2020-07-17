<?php


namespace App\Application\Controllers;

use App\Application\Models\Book;
use App\Application\Models\Role;
use App\Application\Models\Users;
use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\File\Excel;
use App\Components\Http\Request;
use Carbon\Carbon;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        return  Book::chunk(3);
    }
}
