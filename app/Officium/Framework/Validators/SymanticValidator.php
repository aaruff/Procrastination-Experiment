<?php

namespace Officium\Framework\Validators;


interface SymanticValidator
{
    /**
     * Used to determine if the validator should be passed all entries or just a specific entry.
     *
     * @return string Validator::$SINGLE_ENTRY, or Validator::$ALL_ENTRIES
     */
    public function getEntryType();

}