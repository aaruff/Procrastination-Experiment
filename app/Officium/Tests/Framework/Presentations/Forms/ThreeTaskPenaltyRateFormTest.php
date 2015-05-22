<?php
namespace Framework\Forms;


use Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm;

class ThreeTaskPenaltyRateFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $post = [
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE => 'on',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$PENALTY_RATE => '0.5',
            ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            ThreeTaskPenaltyTreatmentForm::$PAYOFF => '12',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm();
        $this->assertTrue($form->validate($post));

        unset($post[ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE]);
        $formTwo = new \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm($post);
        $this->assertTrue($formTwo->validate());
    }

    /**
     * @test
     */
    public function Given_InvalidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $posts = [
            [
                ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
            ],
            [
                ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            ],
            [
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
                ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            ],
            [
                ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
                ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE => 'on',
            ],
            [
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
                ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE => 'on',
                ThreeTaskPenaltyTreatmentForm::$PENALTY_RATE => '0.5',
            ],
            [
                ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
                ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE => 'on',
                ThreeTaskPenaltyTreatmentForm::$PENALTY_RATE => '0.5',
                ThreeTaskPenaltyTreatmentForm::$PAYOFF => '12',
            ],
            [
                ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE => 'on',
                \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$PAYOFF => '12',
                ThreeTaskPenaltyTreatmentForm::$TASK_TIME_LIMIT => '60'
            ],
        ];

        $form = new \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm();
        foreach ($posts as $post) {
            $this->assertFalse($form->validate($post));
        }
    }

    /**
     * @test
     */
    public function Given_InvalidEntriesProvided_When_Validated_Should_ReturnErrors()
    {
        $post = [
            ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
            ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE => 'on',
            ThreeTaskPenaltyTreatmentForm::$PENALTY_RATE => '0.5',
            ThreeTaskPenaltyTreatmentForm::$PAYOFF => '12',
            ThreeTaskPenaltyTreatmentForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm();
        $form->validate($post);
        $this->assertTrue( ! empty($form->getErrors()));
    }

    public function Given_TaskDeadlinesSet_When_GetterCalled_Should_ReturnDeadlinesArray()
    {
        $expect = ['12-01-2015 10:00 am', '12-02-2015 10:00 am', '12-03-2015 10:00 am'];
        $post = [
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => $expect[0],
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => $expect[1],
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => $expect[2]
        ];

        $form = new \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm($post);
        $this->assertEquals($expect, $form->getEntries());
    }

    public function Given_AlternateDeadlineEnabled_When_GetterCalled_Should_ReturnTrue()
    {
        $post = [
            ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$ADJUSTABLE_DEADLINE => 'on',
            ThreeTaskPenaltyTreatmentForm::$PENALTY_RATE => '0.5',
            ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$PAYOFF => '12',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm($post);
        $this->assertTrue($form->getSecondaryDeadlineEnabled());
    }

    public function Given_AlternateDeadlineNotProvided_When_GetterCalled_Should_ReturnFalse()
    {
        $post = [
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$SIZE => '1',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$PENALTY_RATE => '0.5',
            \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            ThreeTaskPenaltyTreatmentForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            ThreeTaskPenaltyTreatmentForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            ThreeTaskPenaltyTreatmentForm::$PAYOFF => '12',
            ThreeTaskPenaltyTreatmentForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new \Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm($post);
        $this->assertFalse($form->getSecondaryDeadlineEnabled());
    }
}
