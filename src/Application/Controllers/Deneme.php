<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Http\Request;
use App\Application\Models\Book;
use App\Components\Reflection\DependencyInject;
use App\Components\Routers\CurrentRouter;

class Deneme
{
    public function index()
    {
        $dep=new DependencyInject();
        $dep->hasRequestClass();
        $dep->hasClasses();
        return CurrentRouter::get()->getRouteName();
    }
}
