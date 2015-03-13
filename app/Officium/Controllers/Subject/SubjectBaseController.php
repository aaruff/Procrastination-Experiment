<?php
namespace Officium\Controllers\Subject;

use Officium\Models\Subject;
use Officium\Controllers\Subject\SubjectLoginController as Login;

class SubjectBaseController
{
    protected $app;
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
        $this->request = $this->app->request;
        $this->response = $this->app->response;
    }

    protected function redirectToLogin()
    {
        $this->app->redirect(Login::route());
    }

    protected function login($credentials)
    {
        $subject = Subject::where('login', '=', $credentials['login'])->first();
        $_SESSION['subject'] = $subject;

        return $subject;
    }

    protected function redirect(Subject $subject)
    {
        if ($subject->status == 0) {
            $this->app->redirect('/subject/questionnaire/a');
        }
    }

    protected function getSubject()
    {
        return $_SESSION['subject'];
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['subject']);
    }

    protected function logout()
    {
        if (isset($_SESSION['subject'])) unset($_SESSION['subject']);
    }
}