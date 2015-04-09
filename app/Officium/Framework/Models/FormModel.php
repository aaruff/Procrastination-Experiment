<?php

namespace Officium\User\Models;


use Illuminate\Database\Eloquent\Model;

abstract class FormModel extends Model
{
    private $keys;
    private $entries;
    private $errors;

    /**
     * Initialize survey keys.
     * @param array $entries
     * @param array $keys
     */
    public function __construct(array $keys, array $entries)
    {
        $this->keys = $keys;

        foreach ($keys as $key) {
            if (isset($entries[$key])) {
                $this->entries[$key] = $entries[$key];
            }
            else {
                $this->entries[$key] = '';
            }
        }
    }

    /**
     * Validates the survey against the provided entries.
     *
     * @return boolean
     */
    abstract public function validate();

    /**
     * Sets form answers.
     *
     * @param array $entries
     */
    public function setEntries(array $entries)
    {
        foreach ($this->keys as $key) {
            $this->entries[$key] = $entries[$key];
        }
    }

    /**
     * Sets survey keys.
     *
     * @return array
     */
    protected function getKeys()
    {
        return $this->keys;
    }

    /**
     * Sets a survey entry.
     *
     * @param $key
     * @param $value
     */
    protected function setEntry($key, $value)
    {
        $this->entries[$key] = $value;
    }

    /**
     * Returns the entry specified by the key param.
     *
     * @param $key
     * @return mixed
     */
    protected function getEntry($key)
    {
        return (isset($this->entries[$key])) ? $this->entries[$key] : null;
    }

    /**
     * Returns form answers.
     *
     * @return array
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Sets errors.
     * @param $errors
     */
    protected function setErrors($errors)
    {
        foreach ($this->keys as $key) {
            if ( isset($errors[$key]) && ! empty($errors[$key]))
                $this->errors[$key] = $errors[$key];
        }
    }

    /**
     * Gets errors.
     * @return mixed
     */
    public function getErrors()
    {
        return (is_array($this->errors)) ? $this->errors : [];
    }

}