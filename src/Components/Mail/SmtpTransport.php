<?php


namespace App\Components\Mail;

use Swift_SmtpTransport;

/**
 * Class SmtpTransport
 * @package App\Components\Mail
 */
class SmtpTransport
{
    /**
     * @var Swift_SmtpTransport
     */
    private Swift_SmtpTransport $transport;

    /**
     * SmtpTransport constructor.
     */
    public function __construct()
    {
        $this->transport = (new Swift_SmtpTransport(config('mail.smtp'), config('mail.port')));
    }

    /**
     * @return Swift_SmtpTransport
     *
     */
    public function setConfigs(): Swift_SmtpTransport
    {
        return  $this->transport->setUsername(config('mail.username'))
        ->setPassword(config('mail.password'))
        ->setEncryption(config('mail.encrypt'));
    }
}
