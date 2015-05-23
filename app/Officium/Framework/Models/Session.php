<?php

namespace Officium\Framework\Models;

class Session
{
    private static $SURVEY_ID = 'survey';
    private static $USER_ID = 'user';
    private static $ROLE = 'role';

    public static function logoutUser()
    {
        unset($_SESSION[self::$USER_ID]);
        unset($_SESSION[self::$ROLE]);
        unset($_SESSION[self::$SURVEY_ID]);
    }

    /**
     * @return \Officium\Experiment\Subject
     */
    public static function getSubject()
    {
        /* @var \Officium\Framework\Models\User $user */
        $user = User::find(self::getUserId());
        return $user->subject;
    }

    /**
     * @return \Officium\Framework\Models\User
     */
    public static function getUser()
    {
        return User::find(self::getUserId());
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
     * @param int $surveyId
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
        return self::getItem(self::$USER_ID, 0) > 0;
    }

    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isSubject()
    {
        return self::isLoggedIn() && self::getItem(self::$ROLE) == User::getSubjectRoleNumber();
    }

    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isExperimenter()
    {
        return self::isLoggedIn() && self::getItem(self::$ROLE) == User::getExperimenterRoleNumber();
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private functions
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    private static function getItem($key, $default = null)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : $default;
    }

}