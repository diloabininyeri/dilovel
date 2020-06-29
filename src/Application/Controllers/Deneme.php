<?php


namespace App\Application\Controllers;

use App\Components\Image\Color;

class Deneme
{
    public function index()
    {
        return view('errors.404');
        http_response_code(500);
        return view(500, ['error'=>77]);
    }
}
