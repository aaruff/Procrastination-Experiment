<?php

namespace Officium\Framework\Models;

use Officium\Subject\Models\Subject;
use Officium\Subject\Models\GameState;
use Officium\Subject\Routers\LoginRouter as SubjectLoginRouter;
use Officium\Experimenter\Routers\LoginRouter as ExperimenterLoginRouter;
use Officium\Subject\Routers\SurveyRouter;

/**
 * Class Auth
 * @package Officium\Models
 */
class Auth
{
    private $session;

    public function __construct(array $session)
    {
        $this->session = $session;
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        if (isset($this->session['subject_id'])) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the route is allowed for the signed in user, otherwise false is returned.
     *
     * @param $route
     * @return bool
     */
    public function isAllowedToVisit($route)
    {
        if ($this->isPublicRoute($route)) {
            return true;
        }

        if ($this->isSubject()) {
            $subject = Subject::getSubject($this->session['subject_id']);
            return $this->isSubjectAllowedToVisit($subject, $route);
        }
        elseif ($this->isExperimenter()) {
            return $this->isExperimenterAllowedToVisit($route);
        }
        else {
            return false;
        }
    }

    private function isPublicRoute($route)
    {
        if ($route == SubjectLoginRouter::uri() || $route == ExperimenterLoginRouter::uri() ) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the subject is logged in, otherwise false is returned.
     *
     * @return bool
     */
    private function isSubject()
    {
        if (isset($this->session['subject_id'])) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the experimenter is logged in, otherwise false is returned.
     *
     * @return bool
     */
    private function isExperimenter()
    {
        if (isset($this->session['experimenter_id'])) {
            return true;
        }

        return false;
    }

    /**
     * @param $route
     * @return bool
     */
    private function isExperimenterAllowedToVisit($route)
    {
        return false;
    }


    /**
     * @param \Officium\Subject\Models\Subject $subject
     * @param $route
     * @return bool
     */
    private function isSubjectAllowedToVisit(Subject $subject, $route)
    {

        switch($subject->state) {
            case GameState::$SURVEY:
                return ($route === SurveyRouter::uri()) ? true : false;
            default:
                false;
        }

        return false;
    }
}