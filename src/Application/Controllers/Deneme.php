<?php


namespace App\Application\Controllers;


use App\Application\Responses\ResponseCollectionUser;
use App\Components\Http\Request;
use App\Application\Models\Users;

class Deneme
{

    public function index(Request $request)
    {


        $users=Users::get();
        return (new ResponseCollectionUser($users))->toJson();

    }

}