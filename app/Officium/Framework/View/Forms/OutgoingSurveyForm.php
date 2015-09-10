<?php

namespace Officium\Framework\View\Forms;

use Officium\Experiment\OutgoingSurvey;
use Officium\Experiment\Subject;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\Session;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\SelectionValidator;
use Officium\Framework\Validators\YesNoValidator;
use Slim\Slim;

class OutgoingSurveyForm extends Form implements Saveable
{
    protected static $DISPLAY_DATE_TIME_FORMAT = 'n/j/y g:i a';

    private $subject;

    private static $COMPARED_MINOR_ASSIGNMENTS = 'compared_minor_assignment';
    private static $MINOR_ASSIGNMENTS_HOURS = 'minor_assignment_hours';

    private static $COMPARED_MAJOR_ASSIGNMENTS = 'compared_major_assignment';
    private static $MAJOR_ASSIGNMENTS_HOURS = 'major_assignment_hours';

    private static $COMPARED_EXAMS = 'compared_exams';
    private static $EXAM_HOURS = 'exam_hours';

    private static $COMPARED_COURSEWORK = 'compared_coursework';
    private static $COURSEWORK_HOURS = 'coursework_hours';

    private static $COMPARED_WORK = 'compared_work';
    private static $WORK_HOURS = 'work_hours';

    private static $COMPARED_SOCIAL = 'compared_social';
    private static $SOCIAL_HOURS = 'social_hours';

    private static $COMPARED_FAMILY = 'compared_family';
    private static $FAMILY_HOURS = 'family_hours';

    private static $HOURS_ALL_TASKS = 'hours_all_tasks';
    private static $STRATEGY = 'strategy';
    private static $ALT_DEADLINE = 'alt_deadline';
    private static $SCHEDULE_USED = 'schedule_used';
    private static $SCHEDULE_FOLLOWED = 'schedule_followed';
    private static $SCHEDULE_EXPLAINED = 'schedule_explained';
    private static $WORKED_LATE_TASK = 'worked_late_task';
    private static $LATE_TASK_EXPLAINED = 'late_task_explained';
    private static $ENJOYED_TASK = 'enjoyed_task';

    /**
     * @param Subject $subject
     */
    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * Stores properties to the session.
     *
     * @param User $user
     *
     * @return void
     */
    public function save(User $user)
    {
        $outgoingSurveyForm = new OutgoingSurvey();
        $outgoingSurveyForm->setComparedMinorAssignments($this->getIntEntry(self::$COMPARED_MINOR_ASSIGNMENTS));
        $outgoingSurveyForm->setHoursMinorAssignment($this->getIntEntry(self::$MINOR_ASSIGNMENTS_HOURS, false));

        $outgoingSurveyForm->setComparedMajorAssignments($this->getIntEntry(self::$COMPARED_MAJOR_ASSIGNMENTS));
        $outgoingSurveyForm->setHoursMajorAssignment($this->getIntEntry(self::$MAJOR_ASSIGNMENTS_HOURS, false));

        $outgoingSurveyForm->setComparedExams($this->getIntEntry(self::$COMPARED_EXAMS));
        $outgoingSurveyForm->setHoursExams($this->getIntEntry(self::$EXAM_HOURS, false));

        $outgoingSurveyForm->setComparedCoursework($this->getIntEntry(self::$COMPARED_COURSEWORK));
        $outgoingSurveyForm->setHoursCoursework($this->getIntEntry(self::$COURSEWORK_HOURS, false));

        $outgoingSurveyForm->setComparedWork($this->getIntEntry(self::$COMPARED_WORK));
        $outgoingSurveyForm->setHoursCoursework($this->getIntEntry(self::$WORK_HOURS, false));

        $outgoingSurveyForm->setComparedSocial($this->getIntEntry(self::$COMPARED_SOCIAL));
        $outgoingSurveyForm->setHoursSocial($this->getIntEntry(self::$SOCIAL_HOURS, false));

        $outgoingSurveyForm->setComparedFamily($this->getIntEntry(self::$COMPARED_FAMILY));
        $outgoingSurveyForm->setHoursFamily($this->getIntEntry(self::$FAMILY_HOURS, false));

        $outgoingSurveyForm->setHoursSpentAllTasks($this->getIntEntry(self::$FAMILY_HOURS, false));
        $outgoingSurveyForm->setStrategy($this->getTextEntry(self::$STRATEGY, false));
        $outgoingSurveyForm->setAltDeadline($this->getTextEntry(self::$ALT_DEADLINE, false));
        $outgoingSurveyForm->setScheduleUsed($this->getBooleanEntry(self::$SCHEDULE_USED, false));
        $outgoingSurveyForm->setScheduleExplained($this->getTextEntry(self::$SCHEDULE_EXPLAINED, false));
        $outgoingSurveyForm->setLateTaskedWorkedOn($this->getBooleanEntry(self::$WORKED_LATE_TASK, false));
        $outgoingSurveyForm->setLateTaskExplained($this->getBooleanEntry(self::$LATE_TASK_EXPLAINED, false));
        $outgoingSurveyForm->setTaskEnjoyment($this->getIntEntry(self::$ENJOYED_TASK, false));

        $outgoingSurveyForm->save();

        $subject = Session::getSubject();
        $subject->setNextState();
        $subject->save();
    }

    public function getFormParameters()
    {
        $academicObligation = $this->subject->getAcademicObligations();
        $externalObligation = $this->subject->getExternalObligations();

        $app = Slim::getInstance();
        $parameters = [
            'minor_assignments' => $academicObligation->getNumMinorAssignments(),
            'major_assignments' => $academicObligation->getNumMajorAssignments(),
            'exams' => $academicObligation->getNumExams(),
            'coursework' => $academicObligation->getHoursCoursework(),
            'work' => $externalObligation->getHoursWork(),
            'social' => $externalObligation->getHoursSocialObligations(),
            'family' => $externalObligation->getHoursFamilyObligations()
        ];

        $app->flashNow('parameters', $parameters);

        return $app->flashData();
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
        $validators[self::$COMPARED_MINOR_ASSIGNMENTS]  = new SelectionValidator([1,2,3], true);
        $validators[self::$MINOR_ASSIGNMENTS_HOURS] = new IntegerValidator(0, 200, false);

        $validators[self::$COMPARED_MAJOR_ASSIGNMENTS]  = new SelectionValidator([1,2,3], true);
        $validators[self::$MAJOR_ASSIGNMENTS_HOURS] = new IntegerValidator(0, 200, false);

        $validators[self::$COMPARED_EXAMS]  = new SelectionValidator([1,2,3], true);
        $validators[self::$EXAM_HOURS] = new IntegerValidator(0, 200, false);

        $validators[self::$COMPARED_COURSEWORK]  = new SelectionValidator([1,2,3], true);
        $validators[self::$COURSEWORK_HOURS] = new IntegerValidator(0, 200, false);

        $validators[self::$COMPARED_WORK]  = new SelectionValidator([1,2,3], true);
        $validators[self::$WORK_HOURS] = new IntegerValidator(0, 200, false);

        $validators[self::$COMPARED_SOCIAL]  = new SelectionValidator([1,2,3], true);
        $validators[self::$SOCIAL_HOURS] = new IntegerValidator(0, 200, false);

        $validators[self::$COMPARED_FAMILY]  = new SelectionValidator([1,2,3], true);
        $validators[self::$FAMILY_HOURS] = new IntegerValidator(0, 200, false);

        $validators[self::$HOURS_ALL_TASKS] = new IntegerValidator(0, 200, false);

        $validators[self::$SCHEDULE_USED] = new YesNoValidator(false);
        $validators[self::$SCHEDULE_FOLLOWED] = new YesNoValidator(false);

        $validators[self::$WORKED_LATE_TASK] = new YesNoValidator(false);

        $validators[self::$ENJOYED_TASK]  = new SelectionValidator([1,2,3,4,5], true);

        return $validators;
    }

}