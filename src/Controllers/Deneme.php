<?php


namespace App\Controllers;


use App\Http\Request;
use App\Models\Users;

class Deneme
{

    public function index(Request $request)
    {
        return Users::find($request->get('id'));
    }

}