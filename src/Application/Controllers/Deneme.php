<?php


namespace App\Application\Controllers;

use App\Application\Request\TcNoVerifyRequest;
use App\Application\Rules\UserMustBeAdmin;
use App\Application\Rules\RequiredRule;
use App\Application\Rules\TcNoVerifyRule;
use App\Components\Arr\CanIterate;
use App\Components\Csrf\CsrfGuard;
use App\Components\Http\Request;

class Deneme extends CanIterate
{
    public function index(Request $request)
    {
        return redirect()->router('form')->withQuery(['id'=>63,'country'=>'turkey'])->withHash('news');


        redirect()->router('form')->withFormError('hatata');
        csrf()->validateToken($request->post('_token'));
        return session()->all();
        /*$validate=$request->validateWithRules([
            new UserMustBeAdmin(),
            new TcNoVerifyRule()
        ]);

        if ($validate->isFailed()) {
            return $validate->getMessages();
        }*/








        return router('index')
            ->withQuery(['id'=>145,'table'=>'users'])
            ->withHash('hash');

        /*return redirect()->router('index',['id'=>455])
            ->withHash('dilocan')
            ->withQuery(['id'=>15,'haber'=>'alasana'])
            ->header();*/
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}
