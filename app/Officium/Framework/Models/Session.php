<?php

namespace Officium\Framework\Models;

use Officium\Experiment\Problem;

class Session
{
    private static $SURVEY_ID = 'survey';
    private static $USER_ID = 'user';
    private static $ROLE = 'role';
    private static $PROBLEM = 'problem';

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
        return self::getSingleKeyItem(self::$USER_ID, 0);
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
        return self::getUserId() > 0 && ! empty(self::getUser());
    }

    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isSubject()
    {
        return self::isLoggedIn() && self::getSingleKeyItem(self::$ROLE) == User::getSubjectRoleNumber();
    }

    /**
     * Returns true if the subject is logged in via this session.
     *
     * @return bool
     */
    public static function isExperimenter()
    {
        return self::isLoggedIn() && self::getSingleKeyItem(self::$ROLE) == User::getExperimenterRoleNumber();
    }

    public static function setTaskProblem($taskNumber, Problem $problem)
    {
        $_SESSION[self::$PROBLEM][$taskNumber] = serialize($problem);
    }

    /**
     * Returns the task's problem if set, otherwise null is returned.
     *
     * @param int $taskNumber
     * @return Problem|null
     */
    public static function getTaskProblem($taskNumber)
    {
        $problem = self::getDoubleKeyItem(self::$PROBLEM, $taskNumber);

        if ($problem != null) {
            return unserialize($problem);
        }

        return null;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private functions
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    private static function getSingleKeyItem($key, $default = null)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : $default;
    }

    /**
     * @param $primaryKey
     * @param $secondaryKey
     * @param $default
     * @return mixed
     */
    private static function getDoubleKeyItem($primaryKey, $secondaryKey, $default = null)
    {
        if ( ! isset($_SESSION[$primaryKey]) || ! isset($_SESSION[$primaryKey][$secondaryKey])) {
            return $default;
        }

        return $_SESSION[$primaryKey][$secondaryKey];
    }

}