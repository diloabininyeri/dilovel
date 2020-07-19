<?php


namespace App\Application\Controllers;

use App\Application\Models\Book;
use App\Application\Models\Role;
use App\Application\Models\Users;
use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\File\Excel;
use App\Components\Flash\HtmlFormValuesStorage;
use App\Components\Http\Request;
use App\Components\Reflection\CodeBeautifier;
use Carbon\Carbon;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return redirect()->router('form')->withOldInput();

        return 1;
        $inputs = $request->check([
            'isim' => 'required|string|max:15',
            'soyad' => 'string|numeric|min:5|date|optional_image'
        ])->validate();


        if ($inputs->isFailed()) {
            return $inputs->getErrors();
        }
        return "validated";
    }


    public function __invoke($name)
    {
        return strtoupper($name).' dir';
    }
}
