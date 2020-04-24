<?php


namespace App\Controllers;


use App\Http\Request;
use App\Models\Users;

class Deneme
{

    public function index(Request $request)
    {
        return Users::findOrFail(2)->getPassword()->get();
    }

}