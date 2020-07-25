<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Http\Request;
use App\Components\Traits\RequestValidation;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    use RequestValidation;

    public function __construct()
    {
        $rules = [
            'image|resim alanı' => 'jpg_image|required',
        ];

        //$this->validate($rules);
    }

    /**
     * @param Request $request
     * @return string
     * @rule(max:255)
     * @rule(required)
     * @rule(string)
     */
    public function index(Request $request)
    {
        return Users::limit(10)->get();
    }
}
