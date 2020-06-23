<?php


namespace App\Application\Controllers;

use App\Application\Request\TcNoVerifyRequest;
use App\Application\Rules\UserMustBeAdmin;
use App\Application\Rules\RequiredRule;
use App\Application\Rules\TcNoVerifyRule;
use App\Components\Http\Request;

class Deneme
{
    public function index(Request $request)
    {
        $validate=$request->validateWithRules([
            new UserMustBeAdmin(),
            new TcNoVerifyRule()
        ]);

        if ($validate->isFailed()) {
            return $validate->getMessages();
        }








        return router('index')
            ->withQuery(['id'=>145,'table'=>'users'])
            ->withHash('hash');

        /*return redirect()->router('index',['id'=>455])
            ->withHash('dilocan')
            ->withQuery(['id'=>15,'haber'=>'alasana'])
            ->header();*/
    }
}
