<?php
namespace Officium\Controllers\Subject;

use Officium\Controllers\Subject\SubjectLoginController as Login;
use Officium\Models\Survey;

class SurveyController extends SubjectBaseController
{
    private $surveys = [
        'a' => ['template' => 'academic.twig', 'survey' => 'GeneralAcademicSurvey'],
        'ao' => ['template' => 'academicObligations.twig', 'survey' => 'AcademicObligationSurvey'],
        'eo' => ['template' => 'externalObligations.twig', 'survey' => 'ExternalObligationSurvey']
    ];

    /**
     * Handles get requests
     *
     * @param $surveyId
     */
    public function get($surveyId)
    {
        $this->app->render('/pages/subject/survey/' . $this->surveys[$surveyId]['template']);
        var_dump($_SESSION['a']->getAnswers());
    }

    /**
     * Handles post requests
     *
     * @param $surveyId
     */
    public function post($surveyId)
    {
        $survey = 'Officium\\Models\\' . $this->surveys[$surveyId]['survey'];
        $this->postSurvey(new $survey($this->app->request->post()), $surveyId);
    }

    /**
     * Handles validation of survey posts
     *
     * @param Survey $survey
     * @param $id
     */
    private function postSurvey(Survey $survey, $id)
    {
        if ( $survey->validate()) {
            $this->app->flash('errors', $survey->getErrors());
            $this->response->redirect(Login::route());
            return;
        }

        $this->setSession($id, $survey);
        $this->response->redirect('/subject/survey/' . $id);
    }
}