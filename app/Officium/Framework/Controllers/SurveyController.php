<?php
namespace Officium\Framework\Controllers;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Models\Session;
use Officium\Framework\View\Forms\SurveyFormFactory;
use \Slim\Slim;

class SurveyController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(SurveyMap::toTemplate(), $app->flashData());
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $app = Slim::getInstance();

        $surveyForm = SurveyFormFactory::make();
        if ( ! $surveyForm->validate($app->request->post())) {
            $app->flash('flash', $surveyForm->getEntriesWithErrors());
            $app->redirect(SurveyMap::toUri());
            return;
        }

        $surveyForm->saveToSession();

        IncomingSurveyState::moveToNextSurvey();
        if (IncomingSurveyState::isSurveyComplete()) {
            var_dump(Session::getAllSurveyFormEntries());
            return;
        }

        $app->redirect(SurveyMap::toUri());
    }
}