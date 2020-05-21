<?php


namespace App\Application\Controllers;


use App\Application\Models\Products;
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
     */
    public function index(TcNoVerifyRequest $request)
    {

        $cart=new Cart();

        $cart->add(Products::find(1));
        $cart->add(Products::find(2));

        $total=$cart->total('price','quantity');
        $allProducts= $cart->get();

        //$cart->delete(Products::find(1)); specific delete item
        //$cart->deleteAll();  flush cart
    }
}
