<?php
namespace Officium\Framework\Controllers;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Maps\GameStateMap;
use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Models\Session;
use Officium\Framework\View\Forms\IncomingSurveyForm;
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
            $surveyForm = new IncomingSurveyForm(Session::getAllSurveyEntries());
            $incomingSurvey = $surveyForm->getIncomingSurveyModel();
            $incomingSurvey->save();

            $subject = Session::getSubject();
            $subject->setState(GameStateMap::$DEADLINE_STATE);
            $subject->save();
        }

        $app->redirect(SurveyMap::toUri());
    }
}