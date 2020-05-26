<?php


namespace App\Components\Auth\User;

use App\Application\Models\Users;
use App\Components\Auth\Hash\Hash;
use App\Components\Database\Model;
use App\Components\Http\Session;

/**
 * Class User
 * @package App\Components\Auth\User
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
        $this->session=new Session();
    }

    /**
     * @param Model $user
     * @return bool
     */
    public function login(Model $user):bool
    {
        return Login::user($user);
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
    public function isCanLogin(string $email, $password):bool
    {
        $passwordColumn=Users::where('email', $email)->first('password');

        if (isset($passwordColumn->password, $passwordColumn)) {
            return Hash::check($password, $passwordColumn->password);
        }
        return  false;
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
     * @return Users|null
     */
    public function get():?Users
    {
        if ($this->check()) {
            return Users::find($this->session->get(Enums::USER_AUTH_SESSION_NAME));
        }
        return null;
    }
}
