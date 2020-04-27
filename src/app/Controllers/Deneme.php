<?php


namespace App\app\Controllers;


use App\app\Responses\ResponseCollectionUser;
use App\Components\Http\Request;
use App\app\Models\Users;

class Deneme
{

    public function index(Request $request)
    {


        $users=Users::get();
        return (new ResponseCollectionUser($users))->toJson();

    }

}