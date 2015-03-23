<?php
namespace Officium\Controllers\Subject\Survey;

use Officium\Controllers\Subject\SubjectBaseController;
use Officium\Models\AcademicObligationSurvey;
use Officium\Models\ExternalObligationSurvey;
use Officium\Models\GeneralAcademicSurvey;
use Officium\Controllers\Subject\SubjectLoginController as Login;
use Officium\Models\Survey;

class IncomingSurveyController extends SubjectBaseController
{
    private $route = '/subject/survey/';

    /**
     * Renders the general academic questionnaire.
     */
    public function getGeneralAcademicSurvey()
    {
        $this->app->render('/pages/subject/survey/academic.twig');
    }

    /**
     * Renders the academic obligation questionnaire.
     */
    public function getAcademicObligationSurvey()
    {
        $this->app->render('/pages/subject/survey/academicObligations.twig');
    }

    /**
     * Renders the academic obligation questionnaire.
     */
    public function getExternalObligationSurvey()
    {
        $this->app->render('/pages/subject/survey/externalObligations.twig');
    }

    private function post(Survey $survey, $routeName)
    {
        if ( $survey->validate()) {
            $this->app->flash('errors', $survey->getErrors());
            $this->response->redirect(Login::route());
            return;
        }

        $this->setSession($routeName, $survey);
        $this->response->redirect($this->route . $routeName);
    }

    /**
     * Processes the general academic post request.
     */
    public function postGeneralAcademicSurvey()
    {
        $this->post(new GeneralAcademicSurvey($this->request->post()), 'ga');
    }

    /**
     * Processes the academic obligations post request.
     */
    public function postAcademicObligationSurvey()
    {
        $this->post(new AcademicObligationSurvey($this->request->post()), 'ao');
    }

    /**
     * Processes the academic obligations post request.
     */
    public function postExternalObligationSurvey()
    {
        $this->post(new ExternalObligationSurvey($this->request->post()), 'eo');
    }
}