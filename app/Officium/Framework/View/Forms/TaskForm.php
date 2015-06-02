<?php

namespace Officium\Framework\View\Forms;


use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;

class TaskForm extends Form implements Saveable
{
    private static $PHRASE = 'phrase';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param array $entries
     */
    public function __construct($entries = [])
    {
        parent::__construct(get_class($this), $entries, $this->getFormValidators());
    }

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

    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getFormValidators()
    {
        $validators = [];
        return $validators;
    }
}