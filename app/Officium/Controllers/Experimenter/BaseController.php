<?php
namespace Officium\Controllers\Experimenter;

use Illuminate\Database\Capsule\Manager as Database;

class BaseController {
    protected $app;
    protected $rules;

    public function __construct() {
        global $app;
        $this->app = $app;
    }

    protected function redirectUnauthorizedRequest()
    {
        $this->app->flash('error', 'Login required');
        $this->app->redirect('/login');
    }

    protected function getExperimenterId($credentials)
    {
        $experimenter = Database::table('experimenter')->select('id')
            ->where('login', '=', $credentials['login'])
            ->where('password', '=', sha1($credentials['password']))->first();

        if (isset($experimenter)) {
            return $experimenter['id'];
        }

        else null;
    }

    protected function login($id)
    {
        $_SESSION['experimenter_id'] = $id;
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['experimenter_id']);
    }

    protected function logout()
    {
        unset($_SESSION['experimenter_id']);
    }

    /**
     * Wrapper for the slim redirect function.
     * @param $dotSlashUrl
     * @param int $status
     */
    protected function redirect($url, $status = 302)
    {
        $this->app->redirect($url, $status);
    }

    /**
     * Simplify the call to the view render and enable dot syntax for file paths
     * @param $template
     * @param $params
     */
    protected function render($template, $params = []){
        /**
         * Enable use to pass in the path to the view as '/' or '.' for example
         * 'foldername/viewname'
         * 'foldername.viewname' this will parse as 'foldername/viewname'
         * then append a .php to the file name
         */
        $view = str_replace('.', '/', $template);
        $this->app->render($view . '.twig', $params);
    }

    protected function getPost($key = null, $default = null)
    {
        return $this->app->request->post($key, $default);
    }

}