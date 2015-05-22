<?php
namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;
use Officium\Framework\Models\User;

/**
 * Class Subject
 * @package Officium\Models
 */
class Subject extends Model
{
    public $timestamps = false;
    protected $table = 'subjects';

    private static $ROLE_ID = 1;

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

    /**
     * Returns the subject with the specified user ID
     *
     * @param $userId
     * @return Subject|null
     */
    public static function getByUserId($userId)
    {
        $user = User::getById($userId);
        return $user->subject;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(get_class(new User()), 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session()
    {
        return $this->belongsTo(get_class(new Session()), 'sessions');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function generalAcademicSurveyAnswers()
    {
        return $this->hasOne('Officium\Model\GeneralAcademicSurveyAnswer', 'general_academic_survey_answers');
    }


}