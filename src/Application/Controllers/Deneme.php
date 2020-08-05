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
        $scroll= ElasticModelExample::scroll();

        return $scroll->deleteId('F');
        $scroll->matchAll();
        $scroll->life('40s');
        $scroll->size(10);
        $collection=$scroll->generateId();
        return $collection;
    }
}
