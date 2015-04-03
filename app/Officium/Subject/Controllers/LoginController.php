<?php
namespace Officium\Subject\Controllers;

use Officium\Subject\Models\Subject;
use Officium\Subject\Routers\StateRouter;
use Officium\Subject\Routers\LoginRouter;

class LoginController extends BaseController
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
        return LoginRouter::uri();
    }
}