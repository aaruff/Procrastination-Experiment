<?php

namespace Officium\Framework\Models;

use Officium\Subject\Models\Subject;
use Officium\Subject\Models\GameState;
use Officium\User\Models\User;
use Officium\User\Routers\LoginRouter;
use Officium\Subject\Routers\SurveyMap;

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
        if ($route == LoginRouter::uri()) {
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
        return isset($this->session['role']) && $this->session['role'] == User::$EXPERIMENTER;
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
                return ($route === SurveyMap::toUri()) ? true : false;
            default:
                false;
        }

        return false;
    }
}