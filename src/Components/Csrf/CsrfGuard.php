<?php


namespace App\Components\Csrf;

use App\Components\Http\Session;
use App\Interfaces\CsrfGuardInterface;

/**
 * Class CsrfGuard
 * @package App\Components\Csrf
 */
class CsrfGuard implements CsrfGuardInterface
{
    /**
     * @var Session
     */
    private Session $session;

    /***
     * CsrfGuard constructor.
     */
    public function __construct()
    {
        $this->session=new Session();
    }

    /**
     * @param string $keyName
     * @return string
     */
    public function generateToken(string $keyName = '__csrf_token'): string
    {
        $token=md5(uniqid('csrf', true));
        $this->session->set($keyName, $token);
        return $token;
    }

    /**
     * @param string $token
     * @param string $csrfKey
     * @return bool
     */
    public function validateToken(string $token, string $csrfKey = '__csrf_token'): bool
    {
        if ($token === null) {
            return false;
        }
        return $this->session->get($csrfKey)===$token;
    }

    /**
     * @param string $csrfKey
     * @return bool
     */
    public function destroyToken(string $csrfKey = '__csrf_token'):bool
    {
        return $this->session->delete($csrfKey);
    }
}
