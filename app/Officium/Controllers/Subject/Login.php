<?php
namespace Officium\Controllers\Subject;

use Officium\Models\Subject;
use Officium\Controllers\BaseController;

class Login extends BaseController
{
    public function get()
    {
        $this->logoutSubject();
        $this->render('pages.subject.login');
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        $post = Request::post();

        // Error Handling
        $errors = Subject::validate($post);
        if ( ! empty($errors)) {
            App::flash('errors', $errors);
            Response::redirect(Login::route());
            return;
        }

        $subject = Subject::where('login', '=', $post['login'])
            ->where('password', '=', sha1($post['password']))->first();

        $this->loginSubject($subject);
        Response::redirect();
    }

    public static function route()
    {
        return '/subject/login';
    }

}