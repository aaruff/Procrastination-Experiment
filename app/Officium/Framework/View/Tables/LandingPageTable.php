<?php

namespace Officium\Framework\View\Tables;

use Officium\Experiment\Subject;
use Officium\Framework\Maps\TaskMap;

class LandingPageTable 
{
    private static $DATE_TIME_FORMAT = 'm/d/Y g:i a';

    public function getData(Subject $subject)
    {
        $tasks = $subject->getSession()->getTreatment()->getTasks();
        $deadlines = $subject->getDeadlines();

        $formData = [];
        $timeNow = new \DateTime('now');
        foreach ($tasks as $i=>$task) {
            $row['url'] = TaskMap::toUri();
            $row['number'] = $task->getNumber();

            $deadline = $deadlines[$i]->getDeadline();
            $row['deadline'] = $deadline->format(self::$DATE_TIME_FORMAT);

            $row['deadline_countdown'] = ($timeNow < $deadline) ? $timeNow->diff($deadline)->format('%R%a days') : '';


            $row['deadline_zero'] = '';

            $row['current_payoff'] = $task->getPayoff();
        }

        return $formData;
    }

}