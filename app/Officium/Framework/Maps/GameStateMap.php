<?php

namespace Officium\Framework\Maps;

use Officium\Experiment\Subject;

class GameStateMap
{
    private static $SURVEY_STATE = 0;

    private $subject;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Returns the uri for the given state.
     *
     * @return string
     */
    public function toUri()
    {
        if ($this->subject->getState() == self::$SURVEY_STATE) {
            return SurveyMap::toUri();
        }
    }
}