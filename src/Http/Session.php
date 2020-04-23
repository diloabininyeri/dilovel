<?php


namespace App\Http;


class Session
{

    private array $session = [];

    public function __construct()
    {
        $this->sessionStart();
        $this->session =& $_SESSION;
    }

    /**
     *
     */
    private function sessionStart()
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
    function get($name, $default = null)
    {
        return trim($this->session[$name]) ?? $default;
    }

    function set(string $name, $value)
    {
        $this->session[$name] = $value;
    }
}