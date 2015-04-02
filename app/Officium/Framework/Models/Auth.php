<?php

namespace Officium\Models;


use Officium\Routers\SurveyRouter;

/**
 * Class Auth
 * @package Officium\Models
 */
class Auth
{
    /**
     * @return bool
     */
    public static function isLoggedIn()
    {
        if (isset($_SESSION['subject_id'])) {
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
    public static function isAllowedToVisit($route)
    {
        if (self::isSubject()) {
            $subject = Subject::getSubject($_SESSION['subject_id']);
            return self::isSubjectAllowedToVisit($subject, $route);
        }
        elseif (self::isExperimenter()) {
            return self::isExperimenterAllowedToVisit($route);
        }
        else {
            return false;
        }
    }

    /**
     * Returns true if the subject is logged in, otherwise false is returned.
     *
     * @return bool
     */
    private static function isSubject()
    {
        if (isset($_SESSION['subject_id'])) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the experimenter is logged in, otherwise false is returned.
     *
     * @return bool
     */
    private static function isExperimenter()
    {
        if (isset($_SESSION['experimenter_id'])) {
            return true;
        }

        return false;
    }

    /**
     * @param $route
     * @return bool
     */
    private static function isExperimenterAllowedToVisit($route)
    {
        return false;
    }


    /**
     * @param Subject $subject
     * @param $route
     * @return bool
     */
    private static function isSubjectAllowedToVisit(Subject $subject, $route)
    {

        switch($subject->state) {
            case GameState::$SURVEY:
                return ($route === SurveyRouter::uri()) ? true : false;
            default:
                false;
        }
    }
}