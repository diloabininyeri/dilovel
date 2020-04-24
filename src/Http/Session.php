<?php


namespace App\Http;

use App\interfaces\Session as SessionInterface;


/**
 * Class Session
 * @package App\Http
 */
class Session implements SessionInterface
{

    /**
     * @var array
     */
    private array $session;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->sessionStart();
        $this->session =& $_SESSION;
    }

    /**
     *
     */
    private function sessionStart(): void
    {
        if( session_status() === PHP_SESSION_NONE )
        {
            session_start();
        }

    }

    /**
     * @param $name
     * @param null $default
     * @return string|null
     */
    public function get($name, $default = null): ?string
    {
        return trim($this->session[$name]) ?? $default;
    }


    /**
     * @param $name
     * @return bool
     */
    public function exists($name):bool
    {
        return isset($this->session[$name]);
    }

    /**
     * @param string $name
     * @param $value
     * @return bool
     */
    public function set(string $name, $value): bool
    {
        $this->session[$name] = $value;
        return $this->exists($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function delete($name):bool
    {
        unset($this->session[$name]);
        return  !$this->exists($name);
    }
}