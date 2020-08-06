<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticModelExample;
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
        $bool=ElasticModelExample::bool();

        return  $bool->mustMatchAll()
            ->size(50)
            ->sortDescByMultiKey('age', 'age')
            ->get();
    }
}
