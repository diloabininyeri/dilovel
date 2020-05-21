<?php


namespace App\Application\Controllers;

use App\Application\Models\Products;
use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Cart\Cart;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @param TcNoVerifyRequest $request
     * @return false|string
     * @throws \JsonException
     */
    public function index(TcNoVerifyRequest $request)
    {

        dd($request);

        //$cart->delete(Products::find(1)); specific delete item
        //$cart->deleteAll();  flush cart
    }
}
