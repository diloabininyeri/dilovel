<?php


namespace App\Controllers;


use App\Http\Request;

class Deneme
{

    public function index(Request $request)
    {

        $request->session()->flushAll();

    }

}