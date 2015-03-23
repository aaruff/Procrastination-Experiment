<?php

namespace Officium\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator;

class AcademicObligationSurvey extends Survey
{
    private $schedules = [
        'minorAssignments' => ['minor_start_date', 'minor_start_time', 'minor_end_date', 'minor_end_time'],
        'majorAssignments' => ['major_start_date', 'major_start_time', 'major_end_date', 'major_end_time'],
        'exams' => ['exam_start_date', 'exam_start_time', 'exam_end_date', 'exam_end_time'],
    ];

    public function __construct()
    {
        parent::__construct(['hours_course_work',
            'minor_start_date_time', 'minor_end_date_time',
            'major_start_date_time', 'major_end_date_time',
            'exam_start_date_time', 'exam_end_date_time'
        ]);
    }

    /**
     * Validates general academic form entries.
     *
     * @return boolean
     */
    public function validate()
    {
        $valid = false;
        if ( ! Validator::int()->notEmpty()->between(0, 1000)) {
            $this->setErrors(['hours_course_work' => 'Invalid number of hours.']);
        }

        // Validate the schedules if entered
        foreach ($this->schedules as $type=>$fields) {
            if ($this->isScheduleSet($fields, $this->getEntries())) {
            }
        }

        return $valid;
    }

    /**
     * Confirm if the specified schedules are in the entries array.
     * @param $scheduleKeys
     * @param $entries
     * @return bool
     */
    private function isScheduleSet(array $scheduleKeys, array $entries)
    {
        foreach ($scheduleKeys as $key) {
            if (! isset($entries[$key])) {
                return false;
            }
        }

        return true;
    }

}