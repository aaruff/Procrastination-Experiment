<?php

namespace Officium\Experiment;


interface State
{
    /**
     * Returns the next state ID
     *
     * @return int
     */
    public function getNextState();
}