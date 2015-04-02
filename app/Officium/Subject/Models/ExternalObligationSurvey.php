<?php

namespace Officium\Subject\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;

class ExternalObligationSurvey extends Survey
{
    public function __construct()
    {
        parent::__construct(['hours_course_work',
            'minor_start_date[]', 'minor_start_time[]', 'minor_end_time[]', 'minor_end_date[]',
            'major_start_date[]', 'major_start_time[]', 'major_end_time[]', 'major_end_date[]',
            'exam_start_date[]', 'exam_start_time[]', 'exam_end_time[]', 'exam_end_date[]',
        ]);
    }

    /**
     * Validates general academic form entries.
     *
     * @return array
     */
    public function validate()
    {
        $errorMessages = [];

        if ( ! Valdiator::int()->notEmpty()->between(0, 1000)) {
            $errorMessages['hours_course_work'] = 'Invalid number of hours.';
        }

        return $errorMessages;
    }

}
