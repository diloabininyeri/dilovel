<?php


namespace App\Application\Controllers;

use App\Application\Request\TcNoVerifyRequest;
use App\Components\Auth\Permission\Permission;
use App\Components\Auth\Permission\PermissionMapperObject;
use App\Components\Collection\Collection;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $inputs = $request->check([
            'isim' => 'required|string|max:15|min:5',
            'soyad' => 'string|numeric|min:5|date|optional_image'
        ])->validate();



        return redirect()
            ->to('haber')
            ->withQuery(['id'=>4])
            ->withHash('dene')
            ->withFormError($inputs->getErrors())
            ->withOldInput()
            ->header();
    }
}
