<?php


namespace App\Application\Controllers;

use App\Components\Http\Request;
use Session;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        return $request->cookie()->get('dizi')->expireToDateTime();
    }
}
