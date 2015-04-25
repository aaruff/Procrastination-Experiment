<?php
namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 * @package Officium\Models
 */
class Subject extends Model
{
    protected $timestamps = false;
    protected $table = 'subjects';

    private static $ROLE_ID = 2;

    /**
     * @param $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * @param $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->session_id = $sessionId;
    }

    /**
     * @return int
     */
    public static function getRole()
    {
        return self::$ROLE_ID;
    }

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Officium\Framework\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session()
    {
        return $this->belongsTo('Officium\Models\Session', 'sessions');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function generalAcademicSurveyAnswers()
    {
        return $this->hasOne('Officium\Model\GeneralAcademicSurveyAnswer', 'general_academic_survey_answers');
    }


}