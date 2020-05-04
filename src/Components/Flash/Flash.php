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
     * @return mixed|string|null
     */
    public function get($name)
    {
        $flashSessionName = $this->createSessionName($name);
        register_shutdown_function(fn () => $this->session->delete($flashSessionName));
        return $this->session->get($flashSessionName);
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
     * @param string $name
     * @return string
     */
    private function createSessionName(string $name): string
    {
        return $this->prefix . $name;
    }
}
