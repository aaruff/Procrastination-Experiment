<?php

namespace Officium\Framework\Maps;

interface StateMap
{
    /**
     * Returns the URI for the current state.
     * @return string
     */
    public function toUriList();
}