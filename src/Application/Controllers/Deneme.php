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
        $d= Users::find(25)->books()->get('id', 'name');
        dd($d);
    }
}
