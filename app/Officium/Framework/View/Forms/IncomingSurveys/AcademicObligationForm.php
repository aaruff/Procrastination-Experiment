<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\AcademicObligationSurvey;
use Officium\Experiment\AcademicObligationDeadline as Deadline;
use Officium\Framework\Validators\ArrayValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\Saveable;
use Officium\Framework\View\Forms\Form;
use Officium\Framework\Models\User;

class AcademicObligationForm extends Form implements Saveable
{
    protected static $DATE_TIME_FORMAT = 'm-d-Y g:i a';
    protected static $DISPLAY_DATE_TIME_FORMAT = 'n/j/y g:i a';

    private static $HOURS_COURSE_WORK = 'hours_course_work';

    private static $NUM_MINOR = 'num_minor';
    private static $NUM_MAJOR = 'num_major';
    private static $NUM_EXAM = 'num_exam';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * Stores properties to the session.
     *
     * @param User $user
     * @return void
     */
    public function save(User $user)
    {
        $survey = new AcademicObligationSurvey();
        $survey->setHoursCourseWork($this->getIntEntry(self::$HOURS_COURSE_WORK));
        $survey->setNumMinorAssignments($this->getIntEntry(self::$NUM_MINOR));
        $survey->setNumMajorAssignments($this->getIntEntry(self::$NUM_MAJOR));
        $survey->setNumberExams($this->getIntEntry(self::$NUM_EXAM));
        $survey->setSubjectId($user->getSubject()->getId());
        $survey->save();

        $survey->academicObligationDeadlines()->saveMany($this->getAllDeadlines());
    }

    public function getFormParameters(User $user)
    {
        $subject = $user->getSubject();
        $session = $subject->getSession();

        return [
            'start'=>$session->getStartDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            'end'=>$session->getEndDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT)
        ];

    }

    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getValidators()
    {
        $validators = [];
        $validators[self::$HOURS_COURSE_WORK] = new IntegerValidator(0, 200);
        $validators[self::$NUM_MINOR] = new IntegerValidator(0, 40);
        $validators[self::$NUM_MAJOR] = new IntegerValidator(0, 40);
        $validators[self::$NUM_EXAM] = new IntegerValidator(0, 40);
        $validators[Deadline::$MINOR_DEADLINE_ID] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[Deadline::$MAJOR_DEADLINE_ID] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[Deadline::$EXAM_DEADLINE_ID] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));

        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return \Officium\Experiment\AcademicObligationDeadline[]
     */
    private function getAllDeadlines()
    {
        $entries = $this->getEntries();

        $deadlineTypes = [Deadline::$MAJOR_DEADLINE_ID, Deadline::$MINOR_DEADLINE_ID, Deadline::$EXAM_DEADLINE_ID];

        $dateTimes = [];
        foreach ($deadlineTypes as $type) {
            if ( ! (isset($entries[$type]) && is_array($entries[$type] && ! empty($entries[$type])))) {
                continue;
            }

            foreach ($entries[$type] as $dateTime) {
                $surveyDateTime = new Deadline();
                $surveyDateTime->setDeadline(\DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $dateTime));
                $surveyDateTime->setType($type);
                $dateTimes[] = $surveyDateTime;
            }
        }

        return $dateTimes;
    }
}