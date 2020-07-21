<?php


namespace App\Application\Controllers;

use App\Components\Http\Controller\AbstractController;
use App\Components\Http\Request;
use App\Components\Lang\Lang;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme extends AbstractController
{
    public function index(Request $request)
    {
        $rules = [
            'isim|xxx optional field name' => 'required|min:15|numeric',
        ];

        $this->validate($request, $rules);

        return __FILE__;
    }
}
