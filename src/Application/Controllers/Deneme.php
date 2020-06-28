<?php


namespace App\Application\Controllers;

use App\Components\Image\Color;

class Deneme
{
    public function index()
    {
        return Color::rgbParse('rgb(255,200,55)');
    }
}
