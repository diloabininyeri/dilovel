<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticModelExample;
use App\Application\Models\Users;
use App\Components\Collection\Collection;
use App\Components\Elasticsearch\Elastic;
use App\Components\Http\Request;
use App\Components\Reflection\RuleAnnotation;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $model=ElasticModelExample::bool();
        $model->mustMatch('name', 'İrem5555');
        return $model->delete();
    }
}
