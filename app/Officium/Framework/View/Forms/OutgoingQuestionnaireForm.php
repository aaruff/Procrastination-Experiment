<?php

namespace Officium\Framework\View\Forms;


use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;

class OutgoingQuestionnaireForm extends Form implements Saveable
{
    protected static $DISPLAY_DATE_TIME_FORMAT = 'n/j/y g:i a';


    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * Stores properties to the session.
     *
     * @param User $user
     *
     * @return void
     */
    public function save(User $user)
    {
        // TODO: Implement save() method.
    }

    public function getFormParameters()
    {

    }

    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */
    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getValidators()
    {
        $validators = [];
        return $validators;
    }

}