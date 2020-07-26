<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Database\Custom\Db;
use App\Components\Http\Request;
use App\Components\Reflection\CodeBeautifier;
use App\Components\Traits\RequestValidation;
use ReflectionObject;

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
        $users=new Users();
        return $users->whereDate('created_at', '2020/05/10', '>')->get();
    }
}
