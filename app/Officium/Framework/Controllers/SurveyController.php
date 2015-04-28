<?php
namespace Officium\Framework\Controllers;

use Officium\Experiment\SurveyState;
use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Models\Session;
use Officium\Framework\Presentations\Forms\SurveyFormFactory;
use \Slim\Slim;

class SurveyController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(SurveyMap::toTemplate(Session::getSurveyState()), $app->flashData());
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $app = Slim::getInstance();

        $surveyForm = SurveyFormFactory::make(Session::getSurveyState());
        if ($surveyForm->validate($app->request->post())) {
            $surveyForm->saveToSession();

            if (SurveyState::isComplete(Session::getSurveyState())) {
                var_dump(Session::getAllSurveyFormEntries());
                return;
            }

            Session::setSurveyId(SurveyState::getNextSurveyId(Session::getSurveyState()));
            $app->redirect(SurveyMap::toUri());
        }
        else {
            $app->flash('flash', $surveyForm->getEntriesWithErrors());
            $app->redirect(SurveyMap::toUri());
        }
    }
}