<?php


namespace App\Components\Csrf;

use App\Components\Flash\Flash;
use App\Interfaces\CsrfGuardInterface;

/**
 * Class CsrfGuard
 * @package App\Components\Csrf
 */
class CsrfGuard implements CsrfGuardInterface
{
    private static ?string  $token=null;
    /**
     * @var Flash
     */
    private Flash $flashSession;

    /***
     * CsrfGuard constructor.
     */
    public function __construct()
    {
        $this->flashSession=new Flash();
    }

    /**
     * @param string $keyName
     * @return string
     */
    public function generateToken(string $keyName = '__csrf_token'): string
    {
        if (!self::$token) {
            $token=md5(uniqid('csrf', true));
            $this->flashSession->set($keyName, $token);
            self::$token=$token;
        }
        return self::$token;
    }

    /**
     * @param string $token
     * @param string $csrfKey
     * @return bool
     */
    public function validateToken(string $token, string $csrfKey = '__csrf_token'): bool
    {
        return $this->flashSession->get($csrfKey)===$token;
    }
}
