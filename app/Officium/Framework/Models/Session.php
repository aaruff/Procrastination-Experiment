<?php

namespace Officium\Framework\Models;


class Session
{
    private static $SURVEY_ID = 'survey_id';

    /**
     * @param $key
     * @param $session
     * @return null
     */
    private static function getItem($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
    }

    public static function getSurveyId()
    {
        return self::getItem(self::$SURVEY_ID);
    }

    public static function setSurveyId($id)
    {
        $_SESSION[self::$SURVEY_ID] = $id;
    }

    public static function setSurveyEntries($key, array $entries)
    {
        $_SESSION[$key] = $entries;
    }
}