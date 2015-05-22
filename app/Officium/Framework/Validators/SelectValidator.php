<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class SelectValidator extends Validator
{
    private $required;

    public function __construct($required = true)
    {
        $this->required = $required;
    }

    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    public function validate($entry)
    {
        $this->clearErrors();
        try {
            if ( ! $this->required) {
                v::when(v::notEmpty(), v::true())->assert($entry);
            }
            else {
                v::notEmpty()->true()->assert($entry);
            }
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setErrors($e->findMessages(['notEmpty'=>self::$NOT_EMPTY, 'true'=>self::$TRUE]));
        }

        return false;
    }
}