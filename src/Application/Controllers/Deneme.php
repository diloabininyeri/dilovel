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
            'isim| sizin isminiz' => 'required|min:15|numeric',
            'image|dosya alanı' => 'optional_image',
        ];

        $this->validate($request, $rules);

        return __FILE__;
    }
}
