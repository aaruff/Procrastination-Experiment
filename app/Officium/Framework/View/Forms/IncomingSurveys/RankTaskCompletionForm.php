<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\RankTaskCompletionSurvey;
use Officium\Framework\Validators\ArraySumValidator;
use Officium\Framework\Validators\ArrayValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\View\Forms\Form;
use Slim\Slim;

class RankTaskCompletionForm extends Form implements Saveable
{
    private static $SCALE = 'scale';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */
    public function getFormParameters()
    {
        $app = Slim::getInstance();
        $parameters = [
            'num_tasks' => ['no tasks', 'one task', 'two tasks', 'three tasks']
        ];

        return $parameters;
    }

    /**
     * Stores properties to the session.
     *
     * @param User $user
     *
     * @return void
     */
    public function save(User $user)
    {
        $scale = $this->getIntArrayEntry(self::$SCALE);
        $subjectId = $user->getSubject()->getId();
        foreach ($scale as $numCompleted => $rank) {
            $survey = new RankTaskCompletionSurvey();
            $survey->setNumberCompleted($numCompleted);
            $survey->setRank($rank);
            $survey->setSubjectId($subjectId);
            $survey->save();
        }
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
        $validators[self::$SCALE] = new ArrayValidator(self::$SCALE, new IntegerValidator(0, 100));
        $validators[self::$SEMANTIC_VALIDATORS] = [self::$SCALE => new ArraySumValidator(self::$SCALE, 100)];
        return $validators;
    }
}