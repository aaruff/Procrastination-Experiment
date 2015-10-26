<?php

namespace Officium\Framework\Validators;


use Officium\Framework\Models\User;

class UserValidator extends Validator implements SymanticValidator
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
     * @param $entries
     *
     * @return boolean
     */
    public function validate($entries)
    {
        $this->clearErrors();

        if ( ! isset($entries[self::$LOGIN]) || ! isset($entries[self::$PASSWORD])) {
            $this->setErrors([self::$LOGIN => 'Invalid Login/Password credentials.']);
            return false;
        }

        return $this->validateCredentials($entries[self::$LOGIN], $password = $entries[self::$PASSWORD]);
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

    public function getEntryType()
    {
        return Validator::$ALL_ENTRIES;
    }
}