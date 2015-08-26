<?php

namespace Officium\Framework\Models;

class Session
{
    private static $SURVEY_ID = 'survey';
    private static $USER_ID = 'user';
    private static $ROLE = 'role';
    private static $PROBLEM = 'problem';
    private STATIC $TASK_NUMBER = 'task_number';
    private static $SOLUTION = 'solution';
    private static $PROBLEM_URL = 'url';
    private static $HOLD = 'hold';

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
        return self::getItem(self::$USER_ID, 0);
    }

    /**
     * Return the task's problem solution.
     *
     * @return String[]
     */
    public static function getProblemSolution()
    {
        return $_SESSION[self::$PROBLEM][self::$SOLUTION];
    }

    public static function getProblemTaskNumber()
    {
        return $_SESSION[self::$PROBLEM][self::$TASK_NUMBER];
    }

    public static function getProblemUrl()
    {
        return $_SESSION[self::$PROBLEM][self::$PROBLEM_URL];
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
     * Save the tasks problem solution.
     * @param array $solution
     */
    public static function setProblemSolution(array $solution)
    {
        $_SESSION[self::$PROBLEM][self::$SOLUTION] = $solution;
    }

    /**
     * Saves the current problem task number.
     * @param $taskNumber
     */
    public static function setProblemTaskNumber($taskNumber)
    {
        $_SESSION[self::$PROBLEM][self::$TASK_NUMBER] = $taskNumber;
    }

    /**
     * @param $url
     */
    public static function setProblemUrl($url)
    {
        $_SESSION[self::$PROBLEM][self::$PROBLEM_URL] = $url;
    }

    /**
     * @param boolean $hold
     */
    public static function setHold($hold)
    {
        $_SESSION[self::$HOLD] = $hold;
    }

    public static function getHold()
    {
        return self::getItem(self::$HOLD, false);
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