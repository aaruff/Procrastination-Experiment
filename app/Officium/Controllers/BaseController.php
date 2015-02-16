<?php
namespace Officium\Controllers;


class BaseController {
    protected $app;

    public function __construct() {
        global $app;
        $this->app = $app;
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