<?php


namespace App\Application\Controllers;

use App\Application\Mappers\ForExampleMapper;
use App\Application\Models\Book;
use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Arr\Arr;
use App\Components\Auth\User\Auth;
use App\Components\Database\Migration\CallMigrationObjects;
use App\Components\Database\Migration\MigrationStorage;
use App\Components\Database\PDOAdaptor;
use App\Components\Mail\Mail;
use App\Components\NullObject;
use App\Components\String\Str;
use JsonException;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @param TcNoVerifyRequest $request
     * @return false|string
     * @throws JsonException
     * @throws \Exception
     */
    public function index(TcNoVerifyRequest $request)
    {
        $mail=new Mail();
        $mail->setSubject('title mail');
        $mail->setTo('berxudar@gmail.com');
        $mail->setView(view('index'));
        $mail->setSender('dilsizkaval@windowslive.com');
        return $mail->send();





        $mapper= Arr::mapper(
            new ForExampleMapper(),
            array(
                ['id'=>12,'name'=>'dılo sürücü'],
                ['id'=>14,'name'=>'aysun kyacı'])
        );


        //App::addDeferObject(new ExampleShutdownListener());
        //return $request->is('mobile');
        //return user()->get();

        /*$mail=new Mail();
        $mail->setSubject('title mail');
        $mail->setTo('berxudar@gmail.com');
        $mail->attach(__FILE__);
        $mail->setBody('message content foo bar ');
        $mail->setFrom('dilsizkaval@windowslive.com');
        return $mail->send();

        $queue=new Queue('test');
        $queue->add(new SendEmail());
        $queue->add(new ExampleQueue('dılo sürücü'));*/


        //$user= $request->user()->get();
        // Auth::user()->isCanLogin('berxudar@gmail.com',1234567);
        //Auth::user()->login(Users::find(34));
        //Auth::user()->logout();
        //return Auth::user()->get();
    }
}
