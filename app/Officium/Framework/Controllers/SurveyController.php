<?php
namespace Officium\Framework\Controllers;

use Officium\Subject\Models\Survey;
use Officium\Subject\Models\SurveyFactory;
use Officium\Subject\Routers\SurveyMap;

class SurveyController extends BaseController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        var_dump($_SESSION);
        $surveyId = $this->getFromSession('survey_id');
        $this->app->render(SurveyMap::toRoute($surveyId));
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
            $this->response->redirect(SurveyMap::toUri());
            return;
        }

        $this->setSession('survey_id', SurveyMap::getNextSurveyId($id));
        $this->setSession($id, $survey->getEntries());
        $this->response->redirect(SurveyMap::toUri());
    }
}