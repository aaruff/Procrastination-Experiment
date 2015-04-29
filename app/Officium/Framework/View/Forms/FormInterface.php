<?php
namespace Officium\Framework\View\Forms;


interface FormInterface {

    /**
     * Validates form entries.
     *
     * @param array $entries
     * @return boolean
     */
    public function validate(array $entries);

    /**
     * Returns form entries.
     *
     * @return array
     */
    public function getEntries();

    /**
     * Returns form keys.
     *
     * @return array
     */
    public function getKeys();

    /**
     * Returns the form type.
     *
     * @return string
     */
    public function getType();

    /**
     * Returns the form validation errors.
     * @return array
     */
    public function getErrors();

    /**
     * Returns form entries along with any errors that occurred.
     *
     * @return array
     */
    public function getEntriesWithErrors();
}