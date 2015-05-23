<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class ExternalObligationDeadline extends Model
{
    public static $WORK_START_DATE_TIME = 'work_start_date_time';
    public static $WORK_END_DATE_TIME = 'work_end_date_time';

    public static $SOCIAL_START_DATE_TIME = 'social_start_date_time';
    public static $SOCIAL_END_DATE_TIME = 'social_end_date_time';

    public static $FAMILY_START_DATE_TIME = 'family_start_date_time';
    public static $FAMILY_END_DATE_TIME = 'family_end_date_time';

    public $timestamps = false;
    protected $table = 'external_obligation_deadlines';

    private static $DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function academicObligationSurvey()
    {
        return $this->belongsTo(get_class(new AcademicObligationSurvey()), 'survey_id');
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
     * @param \DateTime $dateTime
     */
    public function setStartDateTime(\DateTime $dateTime)
    {
        $this->start_deadline = $dateTime->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setEndDateTime(\DateTime $dateTime)
    {
        $this->end_deadline = $dateTime->format(self::$DB_DATE_TIME_FORMAT);
    }

}