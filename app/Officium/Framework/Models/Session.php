<?php

namespace Officium\Framework\Models;


class Session
{
    private static $SURVEY_ID = 'survey_id';
    private static $USER_ID = 'user_id';
    private static $ROLE = 'role';

    /**
     * @param $key
     * @return null|string
     */
    private static function getItem($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
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
     * Returns the user role if it found is session storage, otherwise null is returned.
     *
     * @return null|string
     */
    public static function getRole()
    {
        return self::getSurveyId(self::$ROLE);
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
}