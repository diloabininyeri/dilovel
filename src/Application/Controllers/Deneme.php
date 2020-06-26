<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Http\Request;
use App\Application\Models\Book;
use App\Components\Routers\CurrentRouter;

class Deneme
{
    public function index()
    {
        return CurrentRouter::get()->getRouteName();
    }
}
