<?php


namespace App\Components\Mail;

use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;

/**
 * Class Mail
 * @package App\Components\Mail
 * @mixin Swift_Message
 * @noinspection PhpUnused
 */
class Mail
{
    /**
     * @var Swift_Mailer
     */
    private Swift_Mailer $mailer;
    /**
     * @var Swift_Message
     */
    private Swift_Message $message;


    /**
     * Mail constructor.
     */
    public function __construct()
    {
        $this->mailer=SwiftMailer::initial();
        $this->message=new Swift_Message();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->message->$name(...$arguments);
    }

    public function attach(string $filePath): Swift_Message
    {
        return $this->message->attach(Swift_Attachment::fromPath($filePath));
    }

    /**
     * @return int
     */
    public function send(): int
    {
        return $this->mailer->send($this->message);
    }
}
