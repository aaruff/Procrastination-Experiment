<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\RankTaskCompletionSurvey;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\View\Forms\Form;

class RankTaskCompletionForm extends Form implements Saveable
{
    private static $NO_TASK = 'n';
    private static $ONE_TASK = 'o';
    private static $TWO_TASKS = 't';
    private static $ALL_TASKS = 'a';

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
        $survey = new RankTaskCompletionSurvey();
        $survey->setNoTaskRank($this->getIntEntry(self::$NO_TASK));
        $survey->setOneTaskRank($this->getIntEntry(self::$ONE_TASK));
        $survey->setTwoTaskRank($this->getIntEntry(self::$TWO_TASKS));
        $survey->setAllTaskRank($this->getIntEntry(self::$ALL_TASKS));
        $survey->setSubjectId($user->getSubject()->getId());
        $survey->save();
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
        $validators[self::$NO_TASK] = new IntegerValidator(0, 100);
        $validators[self::$ONE_TASK] = new IntegerValidator(0, 100);
        $validators[self::$TWO_TASKS] = new IntegerValidator(0, 100);
        $validators[self::$ALL_TASKS] = new IntegerValidator(0, 100);
        return $validators;
    }
}