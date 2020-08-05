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
            $id=ElasticModelExample::scroll()->generateId();
            $request->cookie()->set('scroll', $id,60);
        }


        $scrollId=$request->cookie()->get('scroll');

        $scroll= ElasticModelExample::scroll();
        return $scroll->lazyLoad($scrollId, '1m');
    }
}
