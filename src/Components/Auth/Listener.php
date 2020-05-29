<?php


namespace App\Components\Auth;

use App\Application\Listeners\Auth\AuthLoginListener;
use App\Application\Listeners\Auth\AuthLogoutListener;
use App\Application\Listeners\Auth\AuthRegisterListener;
use App\Components\Auth\User\AuthEventListener;
use App\Components\Database\Model;

/**
 * Class Listener
 * @package App\Components\Auth
 */
class Listener extends AuthEventListener
{


    /**
     * @var array|string[]
     */
    protected array $listener = [
        'login' => AuthLoginListener::class,
        'logout' => AuthLogoutListener::class,
        'register'=>AuthRegisterListener::class,
    ];

    /**
     * @param string $event
     * @param $user
     * @return mixed
     */
    public static function fire(string $event, Model $user)
    {
        return (new self())->emit($event, $user);
    }
}
