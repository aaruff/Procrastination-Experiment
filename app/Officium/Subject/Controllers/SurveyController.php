<?php
namespace Officium\Subject\Controllers;

use Officium\Subject\Controllers\LoginController as Login;
use Officium\Subject\Models\Survey;
use Officium\Subject\Models\SurveyFactory;
use Officium\Subject\Routers\SurveyRouter;

class SurveyController extends BaseController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $surveyId = $this->getFromSession('survey_id');
        $this->app->render(SurveyRouter::getTemplateRoute($surveyId));
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $surveyId = $this->getFromSession('survey_id');
        $surveyEntries = $this->request->post();
        $this->postSurvey(SurveyFactory::make($surveyId, $surveyEntries), $surveyId);
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

        $this->setSession('survey_id', $id);
        $this->setSession($id, $survey->getAnswers());
        $this->response->redirect(SurveyRouter::uri());
    }
}