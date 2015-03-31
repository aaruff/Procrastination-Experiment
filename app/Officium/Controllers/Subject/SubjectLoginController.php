<?php
namespace Officium\Controllers\Subject;

use Officium\Models\Subject;
use Officium\Routers\StateRouter;

class SubjectLoginController extends SubjectBaseController
{
    public function get()
    {
        $this->app->render('/pages/subject/login.twig');
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        $credentials = $this->request->post();

        // Error handling
        $errors = Subject::validate($credentials);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(self::route());
            return;
        }

        $subject = $this->login($credentials);
        $this->response->redirect(StateRouter::getRoute($subject));
    }

    public static function route()
    {
        return '/subject/login';
    }

}