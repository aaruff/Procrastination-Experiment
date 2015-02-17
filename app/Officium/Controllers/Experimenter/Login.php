<?php

namespace Officium\Controllers\Experimenter;

use Valitron\Validator as Validator;

/**
 * The Experimenter Login Controller
 *
 * Class Login
 * @package Officium\Controllers\Experimenter
 */
class Login extends BaseController
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Handles the login get request.
     */
    public function get()
    {
        $this->logout();
        $this->render('pages.experimenter.login');
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        $postEntries = $this->getPost();
        $validator = $this->getLoginValidator($postEntries);

        $errors = [];
        if ( ! $validator->validate()) {
            $errors = $validator->errors();
        }

        $experimenterId = $this->getExperimenterId($postEntries);
        if ( ! isset($experimenterId)) {
            $errors[] = 'There seems to be an error in either your login or password. Please try again.';
        }

        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->redirect($this->app->request()->getPath());
        }
        else {
            $this->login($experimenterId);
            $this->redirect('/experiment/dashboard');
        }
    }

    /**
     * Returns the login validator with predefined rules.
     *
     * @param $postEntries
     * @return Validator
     */
    private function getLoginValidator($postEntries)
    {
        $validator = new Validator($postEntries);
        $validator->rule('required', ['login', 'password']);
        $validator->rule('alpha', 'login');
        $validator->rule('lengthMin', '3');
        $validator->rule('lengthMin', '30');

        return $validator;
    }
}