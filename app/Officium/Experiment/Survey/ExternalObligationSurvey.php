<?php

namespace Officium\Experiment\Survey;

use Officium\Framework\Models\FormModel;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;

class ExternalObligationSurvey extends FormModel
{
    public function __construct($entries)
    {
        $keys = [];
        parent::__construct($keys, $entries);
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
