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
    public function subjectTasks()
    {
        return $this->hasMany(get_class(new SubjectTask()));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function academicObligations()
    {
        return $this->hasOne(get_class(new AcademicObligationSurvey()));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function externalObligations()
    {
        return $this->hasOne(get_class(new ExternalObligationSurvey()));
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
     * @param $taskNumber
     *
     * @return \Officium\Experiment\SubjectTask
     */
    public function getDeadline($taskNumber)
    {
        return SubjectTask::where('subject_id', '=', $this->id)->where('task_id', '=', $taskNumber)->first();
    }

    /**
     * @return \Officium\Experiment\SubjectTask[]
     */
    public function getSubjectTasks()
    {
        return $this->subjectTasks;
    }

    /**
     * @return \Officium\Experiment\AcademicObligationSurvey
     */
    public function getAcademicObligations()
    {
        return $this->academicObligations;
    }

    /**
     * @return \Officium\Experiment\ExternalObligationSurvey
     */
    public function getExternalObligations()
    {
        return $this->externalObligations;
    }

    /**
     * @param $taskNumber
     * @return null|SubjectTask
     */
    public function getSubjectTask($taskNumber)
    {
        $tasks = $this->getSubjectTasks();
        foreach ($tasks as $task) {
            if ($task->getTaskNumber() == $taskNumber) {
                return $task;
            }
        }

        //Todo: add logging and exception
        return null;
    }

    public function setNextState()
    {
        $state = StateFactory::makeState($this);
        $this->state = $state->getNextState();
    }
}