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
    protected $table = 'subjects';

    private static $ROLE_ID = 1;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function session()
    {
        return $this->hasOne(get_class(new Session()), 'id', 'session_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function generalAcademicSurvey()
    {
        return $this->hasOne(get_class(new GeneralAcademicSurvey()));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deadlines()
    {
        return $this->hasMany(get_class(new SubjectDeadline()));
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

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
     * @return \Officium\Experiment\SubjectDeadline[]
     */
    public function getDeadlines()
    {
        return $this->deadlines;
    }

    public function setNextState()
    {
        $state = StateFactory::makeState($this);
        $this->state = $state->getNextState();
    }
}