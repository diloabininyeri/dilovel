<?php


namespace App\Components\Auth\User;

use App\Components\Database\Model;
use App\Interfaces\AuthEventListener as AuthEventListenerInterface;

/**
 * Class AuthEventListener
 * @package App\Components\Auth\User
 */
abstract class AuthEventListener
{

    /**
     * @param string $event
     * @param Model $user
     * @return mixed
     */
    public function emit(string $event, Model $user)
    {
        /**
         * @var AuthEventListenerInterface $class
         */
        $class = $this->getEventClass($event);
        if ($class !== null) {
            return call_user_func([new $class(),'handle'], $user);
        }
        return null;
    }

    /**
     * @param string $event
     * @return string|null
     */
    private function getEventClass(string $event):?string
    {
        return $this->listener[$event] ?? null;
    }
}
