<?php

namespace Officium\Experiment;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class SurveyDateTime extends Model
{
    public $timestamps = false;
    protected $table = 'survey_datetime_interval';

    public static $MAJOR_DEADLINE_ID = 'major_deadline';
    public static $MINOR_DEADLINE_ID = 'minor_deadline';
    public static $EXAM_DEADLINE_ID = 'exam_deadline';

    public static $WORK_START_DATE_TIME = 'work_start_date_time';
    public static $WORK_END_DATE_TIME = 'work_end_date_time';

    public static $SOCIAL_START_DATE_TIME = 'social_start_date_time';
    public static $SOCIAL_END_DATE_TIME = 'social_end_date_time';

    public static $FAMILY_START_DATE_TIME = 'family_start_date_time';
    public static $FAMILY_END_DATE_TIME = 'family_end_date_time';

    private static $DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incomingSurvey()
    {
        return $this->belongsTo(get_class(new IncomingSurvey()), 'survey_id');
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */


    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param DateTime $dateTime
     */
    public function setStartDateTime(DateTime $dateTime)
    {
        $this->start_datetime = $dateTime->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * @param DateTime $dateTime
     */
    public function setEndDateTime(DateTime $dateTime)
    {
        $this->end_datetime = $dateTime->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * @return string
     */
    public static function getMajorDeadlineId()
    {
        return self::$MAJOR_DEADLINE_ID;
    }

    /**
     * @return string
     */
    public static function getMinorDeadlineId()
    {
        return self::$MINOR_DEADLINE_ID;
    }

    /**
     * @return string
     */
    public static function getExamDeadlineId()
    {
        return self::$EXAM_DEADLINE_ID;
    }
}