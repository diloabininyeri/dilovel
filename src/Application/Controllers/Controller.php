<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Application\Queue\ExampleQueue;
use App\Application\Queue\SendEmail;
use App\Application\Request\TcNoVerifyRequest;
use App\Components\Auth\Hash\Hash;
use App\Components\Auth\User\Auth;
use App\Components\Mail\Mail;
use App\Components\Queue\Queue;
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



    }
}
