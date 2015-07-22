<?php

namespace Officium\Framework\Controllers;

use Officium\Experiment\SubjectGame;
use Officium\Framework\View\Tables\LandingPageTable;
use Slim\Slim;
use Officium\Framework\Models\Session;
use Officium\Framework\Maps\LandingPageMap as Map;
use Officium\Framework\Maps\OutgoingQuestionnaireMap as OutgoingMap;
use Officium\Experiment\EventLog;


class LandingPageController 
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $subject = Session::getSubject();
        EventLog::logEvent($subject, EventLog::LANDING_PAGE_REQUEST);

        $game = new SubjectGame($subject);
        if ($game->isOver()) {
            $subject = Session::getSubject();
            $subject->setNextState();
            $subject->save();
            $app->redirect(OutgoingMap::toUri());
            return;
        }

        $table = new LandingPageTable();
        $tableData = $table->getData(Session::getSubject());
        $app->render(Map::toTemplate(), $tableData);
    }

}