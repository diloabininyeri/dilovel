<?php


namespace App\app\Controllers;


use App\Http\Request;
use App\app\Models\Users;

class Deneme
{

    public function index(Request $request)
    {
        return Users::find($request->get('id'));
    }

}