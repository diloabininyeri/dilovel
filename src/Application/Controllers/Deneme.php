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
    /**
     * @param Request $request
     * @return string
     * @rule(max:255)
     * @rule(required)
     * @rule(string)
     */
    public function index(Request $request)
    {
        $rules = [
            'image|resim alanı' => 'jpg_image|required',
        ];

        $this->validate($request, $rules);

        return __FILE__;
    }
}
