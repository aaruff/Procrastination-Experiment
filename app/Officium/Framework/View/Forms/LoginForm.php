<?php

namespace Officium\Framework\View\Forms;

use Officium\Framework\Models\User;
use Officium\Framework\Validators\AlphabeticalValidator;
use Officium\Framework\Validators\AlphaNumericValidator;
use Officium\Framework\Validators\UserValidator;

/**
 * This class stores and validates the login form data.
 *
 * @package Officium\Framework\Presentations\Forms
 */
class LoginForm extends Form
{
    public static $LOGIN = 'login';
    public static $PASSWORD = 'password';

    public function __construct($entries = [])
    {
        parent::__construct('Login', $entries, $this->getFormValidators());
    }

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getFormValidators()
    {
        $validators = [];
        $validators[self::$LOGIN] = new AlphabeticalValidator();
        $validators[self::$PASSWORD] = new AlphaNumericValidator();
        $validators[self::$SEMANTIC_VALIDATORS] = [new UserValidator(new User())];
        return $validators;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        $entries = $this->getEntries();
        return $entries[self::$LOGIN];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        $entries = $this->getEntries();
        return $entries[self::$PASSWORD];
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return User::getByLogin($this->getLogin());
    }

    /**
     * @return array
     */
    public function getEntriesWithErrors()
    {
        return ['errors'=>$this->getErrors(), 'login'=>$this->getLogin()];
    }
}