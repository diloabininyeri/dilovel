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
class Deneme extends AbstractController
{
    public function index(Request $request)
    {
        $rules = [
            'isim' => 'required|string|max:15|min:5',
        ];

        $this->validate($request, $rules);

        touch('deneme.txt');
    }
}
