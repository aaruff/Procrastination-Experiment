<?php

namespace Officium\Framework\View\Forms;


/**
 * Class Form
 * @package Officium\Framework\Forms
 */
abstract class Form implements FormInterface
{
    /**
     * The key for the post validation validators
     * @var string
     */
    protected static $SEMANTIC_VALIDATORS = 'semantic_validators';

    /**
     * The key used to perform sematic validation post syntactic validation.
     *
     * @var string
     */
    protected static $SEMATIC_ERROR = 'sematic';

    protected static $FORM_TYPE_KEY = 'form_type';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @var string[]
     */
    private $entries = [];

    /**
     * @var \Officium\Framework\Validators\Validator[]
     */
    private $validators = [];

    /**
     * @param string
     * @param string[]
     * @param \Officium\Framework\Validators\Validator[] $validators
     */
    public function __construct($type, $entries, $validators)
    {
        $this->type = $type;
        $this->entries = $this->filterEntries($entries, array_keys($validators));

        if ( ! isset($validators[self::$SEMANTIC_VALIDATORS])) {
            $validators[self::$SEMANTIC_VALIDATORS] = [];
        }

        $this->validators = $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                     Abstract
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected abstract function getFormValidators();

    /* ------------------------------------------------------------------------------------------
     *                                     Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param string[] $rawEntries
     * @return bool
     */
    public function validate(array $rawEntries = [])
    {
        if ( ! empty($rawEntries) ) {
            $this->entries = $this->filterEntries($rawEntries, array_keys($this->validators));
        }

        if ($this->doSyntacticValidation()) {
            $this->doSematicValidation();
        }

        return empty($this->errors);
    }

    /**
     * @return \string[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the form keys
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->getFormValidators());
    }

    /**
     * Returns the form entry errors
     *
     * @return \string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getEntriesWithErrors()
    {
        return ['errors'=>$this->getErrors(), 'entries'=>$this->getEntries()];
    }


    /* ------------------------------------------------------------------------------------------
     *                                     Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Filters out valid form entries form the raw entries param
     *
     * @param $rawEntries
     * @param $keyFilters
     * @return string[]
     */
    protected function filterEntries($rawEntries, $keyFilters)
    {
        $filtered = [];
        foreach ($keyFilters as $key) {
            if (isset($rawEntries[$key])) {
                $stripCharacterRange = FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH;
                $sanitizedEntry = filter_var(trim($rawEntries[$key]), FILTER_SANITIZE_STRING, $stripCharacterRange);
              $filtered[$key] = htmlspecialchars($sanitizedEntry);
            }
            else {
                $filtered[$key] = '';
            }
        }

        return $filtered;
    }

    /* ------------------------------------------------------------------------------------------
     *                                     Private
     * ------------------------------------------------------------------------------------------ */

    /**
     * Validates the form for syntactic errors.
     *
     * @return bool
     */
    private function doSyntacticValidation()
    {
        $this->errors = [];
        foreach ($this->validators as $key => $validator) {
            if ($key !== self::$SEMANTIC_VALIDATORS && ! $validator->validate($this->entries[$key])) {
                $this->errors[$key] = $validator->getErrors();
            }
        }

        return empty($this->errors);
    }

    /**
     * Validates the entries form for semantic errors.
     *
     * @return bool
     */
    private function doSematicValidation()
    {
        if (empty($this->validators[self::$SEMANTIC_VALIDATORS])) {
            return true;
        }

        /* @var \Officium\Framework\Validators\Validator[] $postValidators */
        $postValidators = $this->validators[self::$SEMANTIC_VALIDATORS];

        $generalErrors = [];
        foreach ($postValidators as $key => $validator) {
            if ( ! $validator->validate($this->entries)) {
                $generalErrors[$key] = $validator->getErrors();
            }
        }

        if ( ! empty($generalErrors)) {
            $this->errors[self::$SEMATIC_ERROR] = $generalErrors;
        }

        return empty($generalErrors);
    }
}