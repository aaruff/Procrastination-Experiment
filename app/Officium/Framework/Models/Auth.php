<?php

namespace Officium\Framework\Models;

use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Maps\SessionMap;
use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Maps\DashboardMap;
use Officium\Experiment\Subject;
use Officium\Framework\Maps\TreatmentMap;

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
        if (isset($this->session['user_id'])) {
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

        if ( ! $this->isLoggedIn()) {
            return false;
        }

        if ($this->isSubject()) {
            $subject = User::find($this->session['user_id'])->subject;
            return $this->isSubjectAllowedToVisit($subject, $route);
        }
        elseif ($this->isExperimenter()) {
            return $this->isExperimenterAllowedToVisit($route);
        }
        else {
            return false;
        }
    }

    /**
     * Returns true if the route is public.
     *
     * @param $route
     * @return bool
     */
    private function isPublicRoute($route)
    {
        if ($route == LoginMap::toUri()) {
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
        return isset($this->session['role']) && $this->session['role'] == User::$SUBJECT;
    }

    /**
     * Returns true if the experimenter is logged in, otherwise false is returned.
     *
     * @return bool
     */
    private function isExperimenter()
    {
        $user = User::find($this->session['user_id']);
        return isset($user) && $user->isExperimenter();
    }

    /**
     * @param $route
     * @return bool
     */
    private function isExperimenterAllowedToVisit($route)
    {
        if (DashboardMap::toUri() == $route) {
            return true;
        }
        elseif (SessionMap::toUri() == $route) {
            return true;
        }
        elseif (TreatmentMap::isUri($route)) {
            return true;
        }

        return false;
    }

    /**
     * @param Subject $subject
     * @param $route
     * @return bool
     */
    private function isSubjectAllowedToVisit(Subject $subject, $route)
    {

        switch($subject->state) {
            case Subject::$SURVEY_STATE:
                return ($route === SurveyMap::toUri()) ? true : false;
            default:
                false;
        }

        return false;
    }
}