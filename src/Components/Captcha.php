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
     * @var string $sessionName
     */
    private string $sessionName='captcha_phrase';

    /**
     * Captcha constructor.
     */
    public function __construct()
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
        return $this->flashSession->get($this->sessionName)===$phrase;
    }

    /**
     * @return string
     */
    public function inline(): string
    {
        $this->flashSession->set($this->sessionName, $this::$instance->getPhrase());
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
