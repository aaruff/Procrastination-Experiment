<?php

namespace Officium\Framework\Models;

class Session
{
    private static $SURVEY_ID = 'survey_id';
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
        return $user->subject;
    }

    /**
     * @param User $user
     */
    public static function loginUser(User $user)
    {
        $_SESSION[self::$USER_ID] = $user->getId();
        $_SESSION[self::$SURVEY_ID] = $user->getRole();
    }

    /**
     * Returns the user ID if it is found in session storage, otherwise null is returned.
     *
     * @return null|string
     */
    public static function getUserId()
    {
        return self::getSurveyId(self::$USER_ID);
    }

    /**
     * Returns survey ID if found in session storage, otherwise null is returned.
     *
     * @return null|string
     */
    public static function getSurveyId()
    {
        return self::getItem(self::$SURVEY_ID);
    }

    /**
     * Adds the survey ID to session storage.
     *
     * @param $id
     */
    public static function setSurveyId($id)
    {
        $_SESSION[self::$SURVEY_ID] = $id;
    }

    /**
     * Adds the survey entries to session storage index by the key param.
     *
     * @param $key
     * @param array $entries
     */
    public static function setSurveyEntries($key, array $entries)
    {
        $_SESSION[$key] = $entries;
    }

    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isSubject()
    {
        return self::getRole() == User::getSubjectRoleNumber();
    }

    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isExperimenter()
    {
        return self::getRole() == User::getExperimenterRoleNumber();
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
        return self::getSurveyId(self::$ROLE);
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