<?php


namespace App\Components\Routers\Redirect;

use App\Components\Flash\Flash;
use App\Components\Flash\FlashError;

/**
 * Class Redirect
 * @package App\Components\Routers\Redirect
 */
class Redirect
{
    /**
     * @var string $url
     */
    private string $url;
    /**
     * @var Flash $flash
     */
    private Flash $flash;

    /**
     * @var FlashError
     */
    private FlashError $flashError;

    /**
     * Redirect constructor.
     */
    public function __construct()
    {
        $this->flash=new Flash();
        $this->flashError=new FlashError();
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return $this
     */
    public function router(string $name, $parameters = []): self
    {
        return $this->setUrl(router($name, $parameters));
    }


    /**
     * @return Redirect
     */
    public function back(): self
    {
        return $this->setUrl($_SERVER['HTTP_REFERER']);
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function with(string $name, $value):self
    {
        $this->flash->set($name, $value);
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function withError(string $name, $value):self
    {
        $this->flashError->set($name, $value);
        return  $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function url(string $url): self
    {
        return $this->setUrl($url);
    }

    /**
     * @param string $url
     * @return Redirect
     */
    private function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /** @noinspection MagicMethodsValidityInspection */
    public function __destruct()
    {
        if (!headers_sent()) {
            return header("location:$this->url");
        }
        return null;
    }
}
