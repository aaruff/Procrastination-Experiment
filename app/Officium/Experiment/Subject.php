<?php
namespace Officium\Experiment;

use Officium\Framework\Models\User;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 * @package Officium\Models
 */
class Subject extends Model
{
    /**
     * @var int
     */
    public static $SURVEY_STATE = 1;

    /**
     * @var bool database timestamp enabled
     */
    public $timestamps = false;

    /**
     * @var string database table name
     */
    protected $table = 'subjects';

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

    /**
     * Validate the subject's credentials.
     *
     * @param $credentials
     * @return array
     */
    public static function validate($credentials)
    {
        $errorMessages = [];

        // Validate input
        try {
            Validator::arr()
                ->key('login', Validator::notEmpty()->length(3, 100)->alpha())
                ->key('password', Validator::notEmpty()->alnum()->length(1, 255))
                ->assert($credentials);
        }
            // Handle authentication errors
        catch (ValidationException $e) {
            $errorMessages = $e->findMessages([
                'login' => 'Invalid Login',
                'password' => 'Invalid Password'
            ]);
        }

        // Check if account exists
        if (empty($errorMessages)) {
            $subject = Subject::where('login', '=', $credentials['login'])->first();

            if ( ! $subject || ! password_verify($credentials['password'], $subject->password)) {
                $errorMessages['login'] = 'Invalid Login or Password';
            }

        }

        return $errorMessages;
    }


    /**
     * @return bool
     */
    public function isPlaying()
    {
        return $this->state == self::$PLAYING;
    }

    /**
     * @param $id
     * @return \Officium\Subject\Models\Subject
     */
    public static function getSubject($id)
    {
        return User::find(intval($id))->subject;
    }

    /**
     * @param $numberSubjects
     * @param $treatmentId
     */
    public static function createSubjects($numberSubjects, $treatmentId)
    {
        for ($i = 0; $i < $numberSubjects; ++$i) {
            $user = new User();
            $user->login = $user->generateLogin();
            $user->password = password_hash($treatmentId . $user->login, PASSWORD_DEFAULT);
            $user->save();

            $subject = new Subject();
            $subject->user_id = $user->id;
            $subject->state = Subject::$SURVEY_STATE;
            $subject->treatment_id = $treatmentId;
            $subject->save();
        }
    }
}