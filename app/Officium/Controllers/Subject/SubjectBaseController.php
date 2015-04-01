<?php
namespace Officium\Controllers\Subject;

use Officium\Models\Subject;
use Officium\Controllers\Subject\SubjectLoginController as Login;

/**
 * Provides subclasses with convenience wrappers for the framework.
 *
 * @package Officium\Controllers\Subject
 */
class SubjectBaseController
{
    /**
     * @var null|\Slim\Slim
     */
    protected $app;
    /**
     * @var \Slim\Http\Request
     */
    protected $request;
    /**
     * @var \Slim\Http\Response
     */
    protected $response;

    /**
     * Sets up framework convenience properties
     */
    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
        $this->request = $this->app->request;
        $this->response = $this->app->response;
    }

    /**
     * Redirects subject to the login page.
     *
     */
    protected function redirectToLogin()
    {
        $this->app->redirect(Login::route());
    }

    /**
     * Logs in the subject with the provided credentials.
     *
     * @param $credentials
     * @return int subject id
     */
    protected function login($credentials)
    {
        $subject = Subject::where('login', '=', $credentials['login'])->first();
        $_SESSION['subject_id'] = $subject->id;

        return $subject->id;
    }

    /**
     * Return the logged in subject
     * @return mixed
     */
    protected function getSubject()
    {
        return Subject::where('id', '=', $_SESSION['subject_id'])->first();
    }

    /**
     * Sets the session value index by the key parameter.
     *
     * @param $key
     * @param $value
     */
    protected function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Returns the session value indexed by the key parameter.
     *
     * @param $key
     * @return mixed
     */
    protected function getFromSession($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Redirects to the url corresponding to the subjects current state in the game.
     * @param Subject $subject
     */
    protected function redirect(Subject $subject)
    {
        if ($subject->status == 0) {
            $this->app->redirect('/subject/survey/a');
        }
    }

    /**
     * Returns true is the subject is currently logged in
     *
     * @return bool
     */
    protected function isLoggedIn()
    {
        return isset($_SESSION['subject_id']);
    }

    /**
     * Logs out subject
     */
    protected function logout()
    {
        if (isset($_SESSION['subject_id'])) unset($_SESSION['subject_id']);
    }
}