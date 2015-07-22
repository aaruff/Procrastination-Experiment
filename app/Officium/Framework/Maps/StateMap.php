<?php

namespace Officium\Framework\Maps;

interface StateMap
{
    /**
     * Returns the URI for the current state.
     * @param string $uri
     * @return string
     */
    public function isStateValidUri($uri);

    /**
     * @return string
     */
    public function getStateUri();
}