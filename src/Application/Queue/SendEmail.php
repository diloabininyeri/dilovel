<?php


namespace App\Application\Queue;

use App\Components\Mail\Mail;
use Exception;
use App\Interfaces\QueueInterface;

/**
 * Class ExampleQueue
 * @package App\Application\Queue
 */
class SendEmail implements QueueInterface
{


    /**
     * @return mixed|string
     */
    public function handle()
    {
        $mail=new Mail();
        $mail->setSubject('title mail');
        $mail->setTo('berxudar@gmail.com');
        $mail->attach(__FILE__);
        $mail->setBody('message content foo bar ');
        $mail->setFrom('dilsizkaval@windowslive.com');
        return $mail->to();
    }

    /**
     * @param Exception $exception
     */
    public function failed(Exception $exception):void
    {
        //write or send mail to info for error log
        $exception->getMessage();
    }
}
