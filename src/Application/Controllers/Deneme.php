<?php


namespace App\Application\Controllers;

use App\Application\Request\TcNoVerifyRequest;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(TcNoVerifyRequest $request)
    {
        $inputs = $request->check([
            'isim' => 'required|string|max:15|min:5',
            'soyad' => 'string|numeric|min:5|date|optional_image'
        ])->validate();

        return redirect()
            ->withFormError($inputs->getErrors())
            ->withOldInput()
            ->back();
    }
}
