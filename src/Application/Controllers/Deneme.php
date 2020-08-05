<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticModelExample;
use App\Application\Models\Users;
use App\Components\Collection\Collection;
use App\Components\Elasticsearch\Elastic;
use App\Components\Http\Request;
use App\Components\Reflection\RuleAnnotation;
use Faker\Factory;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $dd= ElasticModelExample::all(1000)
            ->sortBy('surname', 'desc');


        return $dd->toArray();
    }
}
