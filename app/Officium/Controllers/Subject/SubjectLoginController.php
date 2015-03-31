<?php
namespace Officium\Controllers\Subject;

use Officium\Models\Subject;
use Officium\Routers\StateRouter;
use Officium\Routers\LoginRouter;

class SubjectLoginController extends SubjectBaseController
{
    public function get()
    {
        $this->app->render(LoginRouter::getTemplate());
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

        $this->login($credentials);
        $subject = $this->getSubject();
        $this->response->redirect(StateRouter::getUri($subject->state));
    }

    public static function route()
    {
        return LoginRouter::getUri();
    }
}