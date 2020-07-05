<?php


namespace App\Application\Controllers;

use App\Application\Controllers\Pipes\PipeTest1;
use App\Application\Controllers\Pipes\PipeTest2;
use App\Application\Controllers\Pipes\PipeTest3;
use App\Components\Http\Request;
use App\Components\Next\Pipe;
use Session;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $pipe = new Pipe('merhaba');
        $pipe->addObject(new PipeTest1());
        $pipe->addObject(new PipeTest2());
        $pipe->addObject(new PipeTest3());
        if ($pipe->passed()) {
            return 'congrats you  arrived to end of pipe';
        }
        return  $pipe->getCantNextPipeResponses();
    }
}
