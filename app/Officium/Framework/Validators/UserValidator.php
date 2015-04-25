<?php

namespace Officium\Framework\Validators;


use Officium\Framework\Models\User;

class UserValidator extends Validator
{
    private static $LOGIN = 'login';
    private static $PASSWORD = 'password';

    /**
     * @var \Officium\Framework\Models\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Validates the entry provided.
     * @param $credentials
     *
     * @return boolean
     */
    public function validate($credentials)
    {
        if ( ! isset($credentials[self::$LOGIN]) || ! isset($credentials[self::$PASSWORD])) {
            $this->setErrors([self::$LOGIN => 'Invalid Login/Password credentials.']);
            return false;
        }

        return $this->validateCredentials($credentials[self::$LOGIN], $password = $credentials[self::$PASSWORD]);
    }

    /**
     * @param $login
     * @param $password
     *
     * @return bool
     */
    private function validateCredentials($login, $password)
    {
        $user = $this->user->getByLogin($login);

        if ($user && $user->isPassword($password)) {
            return true;
        }

        $this->setErrors([self::$LOGIN => 'Invalid Login/Password credentials.']);
        return false;
    }
}