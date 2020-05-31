<?php


namespace App\Components\Auth\User;

use App\Application\Models\Users;
use App\Components\Auth\Hash\Hash;
use App\Components\Database\Model;
use App\Components\Http\Session;
use App\Components\NullObject;
use JsonException;

/**
 * Class User
 * @package App\Components\Auth\User
 * @mixin Users
 */
class User
{

    /**
     * @var Session
     */
    private Session $session;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param Model $user
     * @return bool
     */
    public function login(Model $user): bool
    {
        return Login::user($user);
    }


    /**
     * @return NullObject|Users
     */
    public function model()
    {
        if ($this->session->exists(Enums::USER_AUTH_SESSION_NAME)) {
            return Users::find($this->session->get(Enums::USER_AUTH_SESSION_NAME));
        }
        return new NullObject();
    }

    /**
     * @return Logout
     */
    public function logout(): Logout
    {
        return new Logout();
    }

    /**
     * @param string $email
     * @param $password
     * @return bool
     */
    public function isCanLogin(string $email, $password): bool
    {
        $passwordColumn = Users::where('email', $email)->first('password');

        if (isset($passwordColumn->password, $passwordColumn)) {
            return Hash::check($password, $passwordColumn->password);
        }
        return false;
    }

    /**
     * @param array $data
     * @return bool|mixed|object|null
     */
    public function register(array $data)
    {
        return Register::user($data);
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return $this->session->exists(Enums::USER_AUTH_SESSION_NAME);
    }


    /**
     * @return bool
     */
    public function guest():bool
    {
        return  !$this->check();
    }

    /**
     * @return Users|null
     */
    public function get(): ?Users
    {
        if ($this->check()) {
            return $this->model();
        }
        return null;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (Auth::user()->guest()) {
            return new NullObject();
        }
        return $this->model()->$name(...$arguments);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->model()->$name;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->model()->$name);
    }

    /**
     * @return false|string
     * @noinspection MagicMethodsValidityInspection
     * @throws JsonException
     */
    public function __toString()
    {
        return json_encode($this->model(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}
