<?php


namespace App\app\Controllers;


use App\Components\Http\Request;
use App\app\Models\Users;

class Deneme
{

    public function index(Request $request)
    {

        return Users::find(1)->getName();

    }

}