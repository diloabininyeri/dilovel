<?php


namespace App\Application\Controllers;

use App\Components\Http\Request;

class Deneme
{
    public function index(Request $request)
    {
        return router('index')
            ->withQuery(['id'=>145,'table'=>'users'])
            ->withHash('hash');

        /*return redirect()->router('index',['id'=>455])
            ->withHash('dilocan')
            ->withQuery(['id'=>15,'haber'=>'alasana'])
            ->header();*/
    }
}
