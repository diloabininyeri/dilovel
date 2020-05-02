<?php


namespace App\Application\Controllers;


use App\Application\Responses\ResponseCollectionUser;
use App\Components\Collection\Collection;
use App\Components\Http\Request;
use App\Application\Models\Users;

class Deneme
{

    public function index(Request $request)
    {

        $users = new Users();
        return $users->getObserveClass();
    }

}