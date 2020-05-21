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
     * @throws \JsonException
     */
    public function index(TcNoVerifyRequest $request)
    {
        $cart=new Cart();
        $cart->add(Products::find(1), 3);
        $cart->add(Products::find(5), 2);




        $findProduct= $cart->find(5); //specific product from cart is primary key equal is 5
        $total=$cart->total('price', 'quantity');
        $allProducts= $cart->get();

        return $cart->toJson();

        //$cart->delete(Products::find(1)); specific delete item
        //$cart->deleteAll();  flush cart
    }
}
