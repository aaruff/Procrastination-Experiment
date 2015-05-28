<?php

namespace Officium\Framework\View\Forms;

use Officium\Framework\Validators\Validator;

/**
 * Class Form
 * @package Officium\Framework\Forms
 */
abstract class Form implements FormInterface
{
    protected static $DATE_TIME_FORMAT = 'm-d-Y g:i a';

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
        $this->setEntries($entries, array_keys($validators));

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
            if ( ! empty($this->validators[self::$SEMANTIC_VALIDATORS])) {
                $this->doSematicValidation();
            }
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
     * Sets entries after filtering them
     *
     * @param $entries
     * @param str[] $filterKeys Optional filter keys
     */
    protected function setEntries($entries, $filterKeys = [])
    {
        $filters = (empty($filterKeys)) ? array_keys($this->validators) : $filterKeys;
        $this->entries = $this->filterEntries($entries, $filters);
    }

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
                if (is_array($rawEntries[$key])) {
                    $filtered[$key] = $this->sanitizeArray($rawEntries[$key]);
                }
                else {
                    $filtered[$key] = $this->sanitizeString($rawEntries[$key]);
                }
            }
            else {
                $filtered[$key] = '';
            }
        }

        return $filtered;
    }

    /**
     * Returns the specified int entry qualified by its id.
     *
     * @param $id
     * @return int
     */
    protected function getIntEntry($id)
    {
        $entries = $this->getEntries();
        return intval($entries[$id]);
    }

    /**
     * Returns the boolean value indexed by the given id.
     * @param $id
     * @return mixed
     */
    protected function getBooleanEntry($id)
    {
        $entries = $this->getEntries();
        return filter_var($entries[$id], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Returns the specified float entry qualified by its id.
     * @param $id
     * @return float
     */
    protected function getFloatEntry($id)
    {
        $entries = $this->getEntries();
        return floatval($entries[$id]);
    }

    /**
     * Returns the specified float entry qualified by its id.
     * @param $id
     * @return string
     */
    protected function getStringEntry($id)
    {
        $entries = $this->getEntries();
        return (empty($entries[$id])) ? '' : $entries[$id];
    }

    /**
     * Returns the specified float entry qualified by its id.
     * @param $id
     * @return \DateTime
     */
    protected function getDateTime($id)
    {
        $entries = $this->getEntries();
        $dateTime =  (empty($entries[$id])) ? '' : $entries[$id];
        return \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $dateTime);
    }

    /* ------------------------------------------------------------------------------------------
     *                                     Private
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param $entry
     * @return string
     */
    private function sanitizeString($entry)
    {
        $stripCharacterRange = FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH;
        return htmlspecialchars(filter_var(trim($entry), FILTER_SANITIZE_STRING, $stripCharacterRange));
    }

    /**
     * @param array $entries
     * @return array
     */
    private function sanitizeArray(array $entries)
    {
        $sanitized = [];
        foreach ($entries as $entry) {
            $sanitized[] = $this->sanitizeString($entry);
        }

        return $sanitized;
    }

    /**
     * Validates the form for syntactic errors.
     *
     * @return bool
     */
    private function doSyntacticValidation()
    {
        $this->errors = [];
        foreach ($this->validators as $key => $validator) {
            if ($key == self::$SEMANTIC_VALIDATORS) {
                continue;
            }

            $entry = ($validator->getEntryType() == Validator::$SINGLE_ENTRY) ? $this->entries[$key] : $this->entries;
            if (! $validator->validate($entry)) {
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
        /* @var \Officium\Framework\Validators\Validator[] $semanticValidators */
        $semanticValidators = $this->validators[self::$SEMANTIC_VALIDATORS];

        $generalErrors = [];
        foreach ($semanticValidators as $key => $validator) {
            $entry = ($validator->getEntryType() == Validator::$SINGLE_ENTRY) ? $this->entries[$key] : $this->entries;
            if ( ! $validator->validate($entry)) {
                $generalErrors[$key] = $validator->getErrors();
            }
        }

        if ( ! empty($generalErrors)) {
            $this->errors[self::$SEMATIC_ERROR] = $generalErrors;
        }

        return empty($generalErrors);
    }
}