<?php


namespace App\Components\Routers\Redirect;


/**
 * Class Redirect
 * @package App\Components\Routers\Redirect
 */
class Redirect
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @param string $name
     * @param array $parameters
     * @return $this
     */
    public function router(string $name, $parameters = []): self
    {
        return $this->setUrl(router($name,$parameters));
    }


    /**
     * @return Redirect
     */
    public function back(): self
    {
        return $this->setUrl($_SERVER['HTTP_REFERER']);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function url(string  $url):self
    {
        return  $this->setUrl($url);
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