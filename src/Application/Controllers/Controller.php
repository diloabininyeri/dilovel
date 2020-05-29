<?php


namespace App\Application\Controllers;

use App\Application\Models\Book;
use App\Application\Models\Users;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Auth\User\Auth;
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
     */
    public function index(TcNoVerifyRequest $request)
    {
        Auth::user()->login(Users::find(34));

        $userModel = $request->user()->model();
        $userModel->can('book')->view(Book::find(2));


        $policy = Users::find(34)->can('book');
        $policy->view(Book::findOrFail(38));  //user can view book->id=2


        $book = Book::find(2);
        $users = Users::get();


        foreach ($users as $user) {
            echo $user->can('book')->view($book);
        }


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
