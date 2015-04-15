<?php
namespace Officium\Framework\Controllers;

use Officium\Framework\Models\FormModel as Survey;
use Officium\Experiment\Survey\SurveyFactory;
use Officium\Framework\Maps\SurveyMap;
use \Slim\Slim;

class SurveyController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        var_dump($_SESSION);
        $surveyId = $_SESSION['survey_id'];

        $app = Slim::getInstance();
        $app->render(SurveyMap::toRoute($surveyId));
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $surveyId = $_SESSION['survey_id'];

        $app = Slim::getInstance();
        $surveyEntries = $app->request->post();
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
        $app = Slim::getInstance();
        if ( $survey->validate()) {
            $app->flash('errors', $survey->getErrors());
            $app->response->redirect(SurveyMap::toUri());
            return;
        }

        $_SESSION['survey_id'] = SurveyMap::getNextSurveyId($id);
        $_SESSION[$id] = $survey->getEntries();
        $app->response->redirect(SurveyMap::toUri());
    }
}