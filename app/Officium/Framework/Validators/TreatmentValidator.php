<?php

namespace Officium\Framework\Validators;

use Officium\Experiment\Treatment\Treatment;

class TreatmentValidator
{
    public static function isId($id)
    {
        $intValidator = new IntegerValidator(1, 100000);
        if ( $intValidator->validate($id) && ! empty(Treatment::find(intval($id)))) {
            return true;
        }

        return false;
    }
}