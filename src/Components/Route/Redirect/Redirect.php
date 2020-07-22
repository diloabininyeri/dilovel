<?php


namespace App\Components\Route\Redirect;

use App\Components\Enums\FormValidationEnum;
use App\Components\Flash\Flash;
use App\Components\Flash\FlashError;
use App\Components\Flash\HtmlFormValuesStorage;
use App\Components\Http\Request;
use App\Components\Http\Url;

/**
 * Class Redirect
 * @package App\Components\Route\Redirect
 */
class Redirect
{
    /**
     * @var string $url
     */
    private ?string $url=null;
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
        return $this->setUrl(route($name, $parameters));
    }


    /**
     * @param string $path
     * @return $this
     */
    public function to(string $path):self
    {
        $path=sprintf('%s/%s', (new Url())->base(), trim($path, '/'));
        return $this->setUrl($path);
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
        return $this->withError(FormValidationEnum::SESSION_NAME, $error);
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
     * @return $this
     */
    public function withOldInput():self
    {
        $posts=Request::getInstance()->getPost();
        $formFlashSession=HtmlFormValuesStorage::getInstance();
        foreach ($posts as $input=>$value) {
            $formFlashSession->set($input, $value);
        }
        return  $this;
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
