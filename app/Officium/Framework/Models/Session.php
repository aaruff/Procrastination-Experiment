<?php

namespace Officium\Framework\Models;

class Session
{
    private static $SURVEY_ID = 'surveys';
    private static $USER_ID = 'user_id';
    private static $ROLE = 'role';

    public static function logoutUser()
    {
        unset($_SESSION[self::$USER_ID]);
        unset($_SESSION[self::$ROLE]);
    }

    /**
     * @return \Officium\Experiment\Subject
     */
    public static function getSubject()
    {
        $user = User::find(self::getUserId());
        return $user->getSubject();
    }

    /**
     * @param User $user
     */
    public static function loginUser(User $user)
    {
        $_SESSION[self::$USER_ID] = $user->getId();
        $_SESSION[self::$ROLE] = $user->getRole();
    }

    /**
     * Returns the user ID if it is found in session storage, otherwise null is returned.
     *
     * @return null|string
     */
    public static function getUserId()
    {
        return $_SESSION[self::$USER_ID];
    }

    /**
     * Sets the survey ID.
     *
     * @param integer $surveyId
     */
    public static function setSurveyId($surveyId)
    {
        $_SESSION[self::$SURVEY_ID] = $surveyId;
    }

    /**
     * Returns true if the user is logged in.
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION[self::$USER_ID]);
    }

    /**
     * Returns the survey ID
     * @return integer
     */
    public static function getSurveyId()
    {
        return (isset($_SESSION[self::$SURVEY_ID])) ? $_SESSION[self::$SURVEY_ID] : 0;
    }


    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isSubject()
    {
        return self::isLoggedIn() && self::getRole() == User::getSubjectRoleNumber();
    }

    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isExperimenter()
    {
        return self::isLoggedIn() && self::getRole() == User::getExperimenterRoleNumber();
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private functions
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the user role if it found is session storage, otherwise null is returned.
     *
     * @return null|string
     */
    private static function getRole()
    {
        return $_SESSION[self::$ROLE];
    }

    /**
     * @param $key
     * @return null|string
     */
    private static function getItem($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
    }

}