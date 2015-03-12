<?php
namespace Officium\Controllers\Subject;

use Officium\Models\Subject;

class LoginController extends SubjectBaseController
{
    public function get()
    {
        $this->logout();
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
            Response::redirect(self::route());
            return;
        }

        $subject = Subject::where('login', '=', $post['login'])->first();
        $this->login($subject);

        if ($subject->status == 0) {
            return Response::redirect('/subject/questionnaire/a');
        }
    }

    public static function route()
    {
        return '/subject/login';
    }

}