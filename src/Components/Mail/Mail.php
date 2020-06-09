<?php


namespace App\Components\Mail;

use Closure;
use Swift_Attachment;
use Swift_Message;

/**
 * Class Mail
 * @package App\Components\Mail
 * @mixin Swift_Message
 * @noinspection PhpUnused
 * @method static to(string $toMail, Closure $param)
 */
class Mail
{

    /**
     * @var Swift_Message
     */
    private Swift_Message $message;


    /**
     * Mail constructor.
     */
    public function __construct()
    {
        $this->message = new Swift_Message();
    }

    /**
     * @param $renderedContent
     * @return Swift_Message
     */
    public function setView(string $renderedContent): Swift_Message
    {
        $this->message->setContentType('text/html');
        return $this->message->setBody($renderedContent);
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

    /**
     * @param string $filePath
     * @return Swift_Message
     */
    public function attach(string $filePath): Swift_Message
    {
        return $this->message->attach(Swift_Attachment::fromPath($filePath));
    }


    /**
     * @return int
     */
    public function send(): int
    {
        return SwiftMailer::initial()->send($this->message);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        if ($name === 'to') {
            [$toMail, $callback] = $arguments;
            $mailObject=new self();
            $callback($mailObject);
            $mailObject->setTo($toMail);
            return $mailObject->send();
        }
    }
}
