<?php


namespace App\Application\Controllers;

use App\Application\Models\Book;
use App\Application\Models\Phone;
use App\Application\Models\Users;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $users=Users::with('book','product')->limit(10)->get();
        dd($users);
    }
}
