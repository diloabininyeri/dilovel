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
use Carbon\Carbon;
use Mpdf\Mpdf;
use Session;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $users= Users::get()->toArray();
        $excel= Excel::export($users);
        $excel->map(static function ($item) {
            return [
                'sıra'=>$item['id'],
                'oluşturma tarihi'=>Carbon::parse($item['created_at'])->diffForHumans(),
                'isim'=>$item['name'],
                'soyad'=>$item['surname'],
            ];
        });


        $excel->filter(fn ($item) =>$item['sıra']>150);

        // for inspect $excel->toHtml();
        return$excel->download();


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
