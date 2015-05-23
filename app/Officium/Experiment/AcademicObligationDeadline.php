<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class AcademicObligationDeadline extends Model
{
    public static $MAJOR_DEADLINE_ID = 'major_deadline';
    public static $MINOR_DEADLINE_ID = 'minor_deadline';
    public static $EXAM_DEADLINE_ID = 'exam_deadline';

    protected $table = 'academic_obligation_deadlines';

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
    public function setDeadline(\DateTime $dateTime)
    {
        $this->deadline = $dateTime->format(self::$DB_DATE_TIME_FORMAT);
    }
}