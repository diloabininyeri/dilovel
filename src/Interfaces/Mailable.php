<?php


namespace App\Interfaces;

use App\Components\Mail\Mail;

/**
 * Interface Mailable
 * @package App\Interfaces
 */
interface Mailable
{
    /**
     * @param Mail $mail
     * @return Mail
     */
    public function __invoke(Mail $mail):Mail;
}
