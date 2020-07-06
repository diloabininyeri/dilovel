<?php


namespace App\Application\Controllers;

use App\Application\Controllers\Pipes\PipeTest1;
use App\Application\Controllers\Pipes\PipeTest2;
use App\Application\Controllers\Pipes\PipeTest3;
use App\Application\Models\Users;
use App\Components\File\Excel;
use App\Components\Http\Request;

use App\Components\Pipeline\Pipe;
use App\Components\String\Str;
use Session;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $data = Users::limit(5)->get()->toArray();

        return Excel::export($data)
            ->setCharset('UTF-8')
            ->setName('deneme')
            ->setLabels(['rename_id', 'rename_name'])
            ->except(['created_at', 'updated_at'])
            ->filter(fn ($item) =>$item['id']>18)
            ->toHtml();


        /*$pipe = new Pipe('haba');
        $pipe->addObject(new PipeTest1());
        $pipe->addObject(new PipeTest2());
        $pipe->addObject(new PipeTest3());

        if ($pipe->passed()) {
            return 'congrats you  arrived to end of pipe';
        }
        return  $pipe->getResponses();*/
    }
}
