<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticModelExample;
use App\Components\Http\Request;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        if (!$request->cookie()->exists('scroll')) {
            $scroll=ElasticModelExample::scroll();
            $scroll->mustMatch('name', 'Ümran');
            $scroll->mustMatch('age', 8);
            $scroll->mustNotMatch('surname', 'Akman');
            $scroll->life('30s');
            $id=$scroll->generateId();
            $request->cookie()->set('scroll', $id, 30);
        }


        $scrollId=$request->cookie()->get('scroll');

        $scroll= ElasticModelExample::scroll();
        return $scroll->lazyLoad($scrollId, '30s');
    }
}
