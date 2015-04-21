<?php
namespace Officium\Framework\Controllers;

use Officium\Framework\Models\FormModel as Survey;
use Officium\Experiment\Survey\SurveyFactory;
use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Models\Session;
use \Slim\Slim;

class SurveyController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(SurveyMap::toRoute(Session::getSurveyId()));
    }

    /**
     * Handles post requests
     */
    public function post()
    {

        $app = Slim::getInstance();
        $surveyEntries = $app->request->post();
        $this->postSurvey(SurveyFactory::make(Session::getSurveyId(), $surveyEntries));
    }

    /**
     * @param Survey $survey
     */
    private function postSurvey(Survey $survey)
    {
        $app = Slim::getInstance();

        if ( $survey->validate()) {
            $app->flash('errors', $survey->getErrors());
            $app->response->redirect(SurveyMap::toUri());
            return;
        }

        $nextSurveyId = SurveyMap::getNextSurveyId(Session::getSurveyId());
        Session::setSurveyId($nextSurveyId);
        Session::setSurveyEntries($nextSurveyId, $survey->getEntries());

        $app->response->redirect(SurveyMap::toUri());
    }
}