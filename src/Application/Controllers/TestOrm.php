<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;

/**
 * Class TestOrm
 * @package App\Application\Controllers
 */
class TestOrm
{


    /**
     * @return mixed|object|null
     */
    public function index()
    {
        return Users::findOr(18, fn () =>[response()->toJson(['data'=>[],'status'])]);
    }
}
