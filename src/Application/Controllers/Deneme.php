<?php


namespace App\Application\Controllers;

use App\Components\Http\Controller\AbstractController;
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
