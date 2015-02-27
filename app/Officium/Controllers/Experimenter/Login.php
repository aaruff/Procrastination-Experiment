<?php

namespace Officium\Controllers\Experimenter;

use Officium\Controllers\BaseController;
use Officium\Controllers\Experimenter\Experiment\Dashboard;
use Officium\Models\Experimenter;

/**
 * The Experimenter Login Controller
 *
 * Class Login
 * @package Officium\Controllers\Experimenter
 */
class Login extends BaseController
{
    /**
     * Handles the login get request.
     */
    public function get()
    {
        $this->logoutResearcher();
        $this->render('pages.experimenter.login');
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        $post = Request::post();

        // Error Handling
        $errors = Experimenter::validate($post);
        if ( ! empty($errors)) {
            App::flash('errors', $errors);
            Response::redirect(Login::route());
            return;
        }

        $experimenter = Experimenter::where('login', '=', $post['login'])
            ->where('password', '=', sha1($post['password']))->first();

        $this->loginResearcher($experimenter);
        Response::redirect(Dashboard::route());
    }

    public static function route()
    {
        return '/experimenter/login';
    }
}