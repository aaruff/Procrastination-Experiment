<?php
namespace Officium\Controllers\Subject;

use Officium\Controllers\BaseController;

class SubjectBaseController extends BaseController
{
    protected function redirectToLogin()
    {
        $this->app->redirect(Login::route());
    }

    protected function login($subject)
    {
        $_SESSION['subject'] = $subject;
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
        unset($_SESSION['subject']);
    }
}