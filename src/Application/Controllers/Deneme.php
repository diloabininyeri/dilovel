<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return string
     * @rule(max:255)
     * @rule(required)
     * @rule(string)
     */
    public function index(Request $request)
    {
        return Users::whereDateForHumans('created_at', '3 weeks ago', '>')->get();
    }
}
