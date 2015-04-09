<?php

namespace Officium\Subject\Models;

use Officium\User\Models\FormModel;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator;

class AcademicObligationSurvey extends FormModel
{
    private $keys = ['hours_course_work', 'minor_start_date', 'minor_start_time', 'minor_end_date', 'minor_end_time',
            'major_start_date', 'major_start_time', 'major_end_date', 'major_end_time',
            'exam_start_date', 'exam_start_time', 'exam_end_date', 'exam_end_time'
        ];

    private $schedules = [
        'minorAssignments' => ['minor_start_date', 'minor_start_time', 'minor_end_date', 'minor_end_time'],
        'majorAssignments' => ['major_start_date', 'major_start_time', 'major_end_date', 'major_end_time'],
        'exams' => ['exam_start_date', 'exam_start_time', 'exam_end_date', 'exam_end_time'],
    ];

    /**
     * @param array $entries
     */
    public function __construct($entries)
    {
        parent::__construct($this->keys, $entries);
    }

    /**
     * Validates general academic form entries.
     *
     * @return boolean
     */
    public function validate()
    {
        try {
            Validator::arr()
                ->key('hours_course_work', Validator::notEmpty()->int()->between(0, 1000))
                ->assert($this->getEntries());
            return true;
        } // Handle authentication errors
        catch (ValidationException $e) {
            $this->setErrors($e->findMessages([
                'hours_course_work' => 'Invalid Entry',
            ]));
        }

        return false;
    }
}