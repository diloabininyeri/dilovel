<?php


namespace App\Interfaces;

/**
 * Interface CsrfGuardInterface
 * @package App\Interfaces
 */
interface CsrfGuardInterface
{
    /**
     * Generate a CSRF token.
     * @param string $keyName
     * @return string
     */
    public function generateToken(string $keyName = '__csrf') : string;

    /**
     * @param string $token
     * @param string $csrfKey
     * @return bool
     */
    public function validateToken(string $token, string $csrfKey = '__csrf') : bool;
}
