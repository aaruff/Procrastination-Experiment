<?php

namespace Officium\Framework\View\Forms;


class DeadlineForm extends Form
{
    public function __construct($entries = [])
    {
        parent::__construct('Deadline', $entries, $this->getFormValidators());
    }

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getFormValidators()
    {
        // TODO: Implement getFormValidators() method.
    }
}