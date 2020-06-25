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

    private ?string $query = null;

    private ?string $hash = null;
    /**
     * @var FlashError
     */
    private FlashError $flashError;

    /**
     * @var bool
     */
    private bool $isRequiredHeader=true;

    /**
     * Redirect constructor.
     */
    public function __construct()
    {
        $this->flash = new Flash();
        $this->flashError = new FlashError();
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
    public function with(string $name, $value): self
    {
        $this->flash->set($name, $value);
        return $this;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function withQuery(array $query): self
    {
        $this->query = http_build_query($query);
        return $this;
    }

    /**
     * @param string $hash
     * @return $this
     */
    public function withHash(string $hash): self
    {
        $this->hash = '#' . $hash;
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function withError(string $name, $value): self
    {
        $this->flashError->set($name, $value);
        return $this;
    }

    /**
     * @param $error
     * @return $this
     */
    public function withFormError($error):self
    {
        return $this->withError('form_validation_error', $error);
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


    /**
     * @return string
     */
    public function getUrl():string
    {
        $this->isRequiredHeader=false;
        if (!$this->hash) {
            return $this->url . ($this->query ? "?$this->query" : null);
        }
        return $this->url . ($this->query ? "?$this->query" : null) . $this->hash;
    }


    public function header()
    {
        if (!headers_sent()) {
            if (!$this->hash) {
                return header("location:$this->url" . ($this->query ? "?$this->query" : null));
            }
            return header('location:' . $this->url . ($this->query ? "?$this->query" : null) . $this->hash);
        }
        return null;
    }



    public function __destruct()
    {
        if ($this->isRequiredHeader) {
            $this->header();
        }
    }
}
