<?php
namespace Officium\Framework\Controllers;

use Officium\Framework\Models\FormModel as Survey;
use Officium\Experiment\Survey\SurveyFactory;
use Officium\Framework\Maps\SurveyMap;

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
    private function postSurvey(FormModel $survey, $id)
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