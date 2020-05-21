<?php


namespace App\Components\Mail;

use Swift_Mailer;

/**
 * Class SwiftMailer
 * @package App\Components\Mail
 */
class SwiftMailer
{

    /**
     * @return Swift_Mailer
     */
    public static function initial(): Swift_Mailer
    {
        $transport=new SmtpTransport();
        return  new Swift_Mailer($transport->setConfigs());
    }
}
