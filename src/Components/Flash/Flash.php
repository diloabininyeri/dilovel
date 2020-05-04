<?php


namespace App\Components\Flash;

use App\Components\Http\Session;

/**
 * Class Flash
 * @package App\Components\Flash
 */
class Flash
{

    /**
     * @var Session $session
     */
    private Session $session;

    /**
     * @var string $prefix
     */
    private string $prefix = 'flash_';

    /**
     * Flash constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function set($name, $value): self
    {
        return $this->setFlashSession($name, $value);
    }

    /**
     * @param $name
     * @param null $type
     * @return mixed|string|null
     */
    public function get($name, $type=null)
    {
        $flashSessionName = $this->createSessionName($name);
        $this->destroyFlash($flashSessionName);
        if ($type === null) {
            return $this->session->get($flashSessionName);
        }
        return  $this->createTemplate($flashSessionName, $type);
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    private function setFlashSession($name, $value): self
    {
        $this->session->set($this->createSessionName($name), $value);
        return $this;
    }

    /**
     * @param $flashSessionName
     */
    private function destroyFlash($flashSessionName):void
    {
        register_shutdown_function(fn () => $this->session->delete($flashSessionName));
    }

    /**
     * @param $flashSessionName
     * @param $type
     * @return string
     */
    private function createTemplate($flashSessionName, $type):?string
    {
        if ($this->session->exists($flashSessionName)) {
            $flash=$this->session->get($flashSessionName);
            return /**@lang HTML */ "<div class='alert alert-$type'>$flash</div>";
        }
        return null;
    }

    /**
     * @param string $name
     * @return string
     */
    private function createSessionName(string $name): string
    {
        return $this->prefix . $name;
    }
}
