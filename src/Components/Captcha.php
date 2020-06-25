<?php


namespace App\Components;

use App\Components\Flash\Flash;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Class Captcha
 * @package App\Components
 * @mixin CaptchaBuilder
 */
class Captcha
{
    /**
     * @var CaptchaBuilder|null
     */
    private static ?CaptchaBuilder $instance = null;

    /**
     * @var Flash
     */
    private Flash $flashSession;


    /**
     * Captcha constructor.
     * @param int $width
     * @param int $height
     * @param null $font
     * @param null $fingerprint
     */
    public function __construct($width=150, $height=40, $font=null, $fingerprint=null)
    {
        if (!$this::$instance) {
            $this::$instance = new CaptchaBuilder();
            $this::$instance->build();
        }
        $this->flashSession=new Flash();
    }

    /**
     * @param string $phrase
     * @return bool
     */
    public function verify(string $phrase): bool
    {
        return $this->flashSession->get('captcha_phrase')===$phrase;
    }

    /**
     * @return string
     */
    public function inline(): string
    {
        $this->flashSession->set('captcha_phrase', $this::$instance->getPhrase());
        return $this::$instance->inline();
    }
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this::$instance->$name(... $arguments);
    }
}
