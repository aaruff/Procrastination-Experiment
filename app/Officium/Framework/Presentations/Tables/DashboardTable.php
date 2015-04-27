<?php

namespace Officium\Framework\Presentations\Tables;


use Officium\Experiment\Session;

class DashboardTable
{
    /**
     * Returns the session table data.
     *
     * @return array
     */
    public function getTableData()
    {
        $sessions = Session::all();

        $rows = [];
        foreach($sessions as $session) {
            $subjects = [];
            foreach ($session->subjects as $subject) {
                $subjects[] = array_merge($subject->toArray(), $subject->user->toArray());
            }

            $rows[] = [
                'session'=>$session->toArray(),
                'treatment'=>$session->treatment->toArray(),
                'tasks'=>$session->treatment->tasks->toArray(),
                'subjects'=>$subjects
            ];
        }

        return ['table'=>$rows];
    }
}