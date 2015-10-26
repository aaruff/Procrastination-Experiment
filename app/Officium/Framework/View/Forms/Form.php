<?php

namespace Officium\Framework\View\Forms;

use Officium\Framework\Validators\Validator;

/**
 * The Form class is the parent class for all forms, and is used to store and validate its entries.
 *
 * @package Officium\Framework\Forms
 */
abstract class Form implements FormInterface
{
    protected static $DATE_TIME_FORMAT = 'm-d-Y h:i a';

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
    protected static $SEMANTIC_ERROR = 'semantic';

    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @var string[]
     */
    private $entries = [];

    /* ------------------------------------------------------------------------------------------
     *                                     Abstract
     * ------------------------------------------------------------------------------------------ */

    /**
     * This validate function is used by the form to validate form entries. The return value is an array of validators,
     * indexed by their entry key, or by the semantic validator key. There are two kinds of validators syntactic,
     * and semantic.
     *
     * Syntactic Validators:
     * -------------------------
     * Are used to validate individual entries, or an array of entries.
     * Syntactic validators are provided to this validator via the getValidators() function, set in the child class.
     *
     *  Usage:
     *  ------
     *       return ['key'=> new Validator()]
     *
     *  Where the key is the entry key, and "new Validator()" is the validator used to validate the provided entry.
     *  Multiple validators can be used for a single entry as follows:
     *       return ['key'=> new ValidatorOne(), 'key' => new ValidatorTwo()]
     *
     * Semantic Validators:
     * --------------------------
     * Are used to validate the semantic meaning of an entry, or entries. Usually more than one entry must be inspected
     * after the syntactic validation has been performed in order to determine its validity. Semantic validators are
     * executed only if all the syntactic validators have passed. Semantic validators are set in the return array of the
     * getValidators() function, which is extended by all form classes.
     *
     *  Usage:
     *  ------
     *       return [Form::$SEMANTIC_VALIDATORS => [new Validator()]]
     *  or
     *       return [FORM::$SEMANTIC_VALIDATORS => ['key'=>new Validator()]
     *
     * If an entry key is used as the validators key it will be used as the key for any corresponding errors that
     * are found upon validation. If no key is used the the corresponding validator errors will be numerically indexed.
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected abstract function getValidators();

    /* ------------------------------------------------------------------------------------------
     *                                     Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * The validate function uses the validators retrieved from the getValidators() function to validate
     * form entries.
     *
     * @param string[] $unfiltered
     * @return bool
     */
    public function validate(array $unfiltered = [])
    {
        $validators = $this->getValidators();
        if ( ! empty($unfiltered) ) {
            $this->entries = $this->filterEntries($unfiltered, array_keys($validators));
        }

        if ($this->doSyntacticValidation()) {
            if ( ! empty($validators[self::$SEMANTIC_VALIDATORS])) {
                $this->doSematicValidation();
            }
        }

        return empty($this->errors);
    }

    /**
     * @return string[]
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
        return array_keys($this->getValidators());
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
        return ['validation_error'=>true, 'errors'=>$this->getErrors(), 'entries'=>$this->getEntries()];
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
     * @param bool
     *
     * @return int
     */
    protected function getIntEntry($id, $required = true)
    {
        $entries = $this->getEntries();

        if ( ! $required && ( ! isset($entries[$id]) || $entries[$id] == '')) {
            return null;
        }

        return intval($entries[$id]);
    }

    /**
     * Returns null if the entry is not set and isn't required, otherwise the sanitized string entry is returned.
     *
     * @param int $id
     * @param bool|true $required
     * @return mixed|string
     */
    protected function getTextEntry($id, $required = true)
    {
        $entries = $this->getEntries();

        if ( ! $required && ( ! isset($entries[$id]) || $entries[$id] == '')) {
            return null;
        }

        return filter_var($entries[$id], FILTER_SANITIZE_STRING);
    }

    /**
     *
     * Returns the boolean value indexed by the given id.
     * @param $id
     * @param bool|true $required
     * @return mixed
     */
    protected function getBooleanEntry($id, $required = true)
    {
        $entries = $this->getEntries();
        if ( ! $required && ( ! isset($entries[$id]) || $entries[$id] == '')) {
            return null;
        }

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
     * Returns the string array entries indexed by the id provided.
     *
     * @param string $id
     * @return string[]
     */
    protected function getAlphaArrayEntry($id)
    {
        $entries = $this->getEntries();
        $alphaValues = [];
        if (isset($entries[$id]) && is_array($entries[$id])) {
            foreach ($entries[$id] as $key => $value) {
                $alphaValues[$key] = filter_var($value, FILTER_SANITIZE_STRING);
            }
        }

        return $alphaValues;
    }

    /**
     * Returns the int array entries indexed by the provided id.
     *
     * @param string $id
     * @return string[]
     */
    protected function getIntArrayEntry($id)
    {
        $entries = $this->getEntries();
        $entryArray = [];
        if (isset($entries[$id]) && is_array($entries[$id])) {
            foreach ($entries[$id] as $key => $value) {
                $entryArray[$key] = intval($value);
            }
        }

        return $entryArray;
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

        $validators = $this->getValidators();
        foreach ($validators as $key => $validator) {
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
        $validators = $this->getValidators();

        /* @var \Officium\Framework\Validators\Validator[] $semanticValidators */
        $semanticValidators = $validators[self::$SEMANTIC_VALIDATORS];

        $generalErrors = [];
        foreach ($semanticValidators as $key => $validator) {
            // When the validator entry type is SINGLE_ENTRY, the validate function is called with the specified entry,
            // otherwise the validate function is called with an array containing all of the entries.
            $entry = ($validator->getEntryType() == Validator::$SINGLE_ENTRY) ? $this->entries[$key] : $this->entries;
            if ( ! $validator->validate($entry)) {
                $generalErrors[$key] = $validator->getErrors();
            }
        }

        if ( ! empty($generalErrors)) {
            $this->errors[self::$SEMANTIC_ERROR] = $generalErrors;
        }

        return empty($generalErrors);
    }
}