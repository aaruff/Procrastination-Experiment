<?php

namespace Officium\Framework\View\Tables;

use Officium\Experiment\Subject;
use Officium\Framework\Maps\TaskMap;
use Officium\Experiment\SubjectGame;

class LandingPageTable 
{
    public function getData(Subject $subject)
    {
        $game = new SubjectGame($subject);
        $numTasks = $game->getNumTasks();

        $rows['rate'] = $game->getPenaltyRatePerHour(1);
        $rows['state']['fixed'] = $game::FIXED_PAYOFF;
        $rows['state']['penalty'] = $game::PENALIZED_PAYOFF;
        $rows['state']['expired'] = $game::NO_PAYOFF;
        $rows['state']['complete'] = $game::COMPLETED;
        for ($i = 1; $i <= $numTasks; ++$i) {
            $row['access'] = $game->isTaskAccessible($i);
            $row['state'] = $game->getTaskState($i);
            $row['url'] = TaskMap::toUri($i);
            $row['number'] = $i;
            $row['deadline'] = $game->getDeadlineString($i);
            $row['countdown'] = $game->getTimeRemaining($i);
            $row['pay'] = $game->getTaskPayoff($i);

            $rows['rows'][] = $row;
        }

        return $rows;
    }
}