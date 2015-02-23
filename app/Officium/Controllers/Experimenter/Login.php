<?php

namespace Officium\Controllers\Experimenter;

use Officium\Controllers\Experimenter\Experiment\Dashboard;
use Officium\Models\Experimenter as Experimenter;
use Illuminate\Database\Capsule\Manager as Capsule;

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

    public static function route()
    {
        return '/experimenter/login';
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

        // Error Handling
        $errors = Experimenter::validate($postEntries);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->app->redirect(Login::route());
            return;
        }

        // Login Researcher
        $experimenter = Capsule::table('experimenter')->select('id')
            ->where('login', '=', $postEntries['login'])
            ->where('password', '=', sha1($postEntries['password']))->first();

        $this->login($experimenter);
        $this->app->redirect(Dashboard::route());
    }
}