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
    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return (Session::getUserId() == null) ? false : true;
    }

    /**
     * Returns true if the route is allowed for the signed in user, otherwise false is returned.
     *
     * @param $route
     * @return bool
     */
    public function isAllowedToVisit($route)
    {
        // Public routes and allowed without authentication
        if ($this->isPublicRoute($route)) {
            return true;
        }

        // All other routes require authentication
        if ( ! $this->isLoggedIn()) {
            return false;
        }

        if (Session::isSubject()) {
            $subject = Subject::getByUserId(Session::getUserId());
            return $this->isSubjectAllowedToVisit($subject, $route);
        }
        elseif (Session::isExperimenter()) {
            return $this->isExperimenterAllowedToVisit($route);
        }
        else {
            // Unauthenticated
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