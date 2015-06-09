<?php

namespace Officium\Framework\View\Tables;

use Officium\Experiment\Subject;

class LandingPageTable 
{
    public function getData(Subject $subject)
    {
        $tasks = $subject->getSession()->getTreatment()->tasks;
        $subjectDeadlines =  $subject->getDeadlines;

    }

}