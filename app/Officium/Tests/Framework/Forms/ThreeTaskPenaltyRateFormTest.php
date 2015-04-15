<?php
namespace Framework\Forms;


use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;

class ThreeTaskPenaltyRateFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $post = [
            ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
            ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY => 'on',
            ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
            ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
            ThreeTaskPenaltyRateForm::$TASK_TIME_LIMIT_KEY => '60'
        ];

        $form = new ThreeTaskPenaltyRateForm();
        $this->assertTrue($form->validate($post));

        unset($post[ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY]);
        $formTwo = new ThreeTaskPenaltyRateForm($post);
        $this->assertTrue($formTwo->validate());
    }

    /**
     * @test
     */
    public function Given_InvalidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $posts = [
            [
                ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
            ],
            [
                ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
                ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
            ],
            [
                ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
                ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
            ],
            [
                ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
                ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY => 'on',
            ],
            [
                ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
                ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY => 'on',
                ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
            ],
            [
                ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
                ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY => 'on',
                ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
                ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
            ],
            [
                ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
                ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY => 'on',
                ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
                ThreeTaskPenaltyRateForm::$TASK_TIME_LIMIT_KEY => '60'
            ],
        ];

        $form = new ThreeTaskPenaltyRateForm();
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
            ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
            ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY => 'on',
            ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
            ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
            ThreeTaskPenaltyRateForm::$TASK_TIME_LIMIT_KEY => '60'
        ];

        $form = new ThreeTaskPenaltyRateForm();
        $form->validate($post);
        $this->assertTrue( ! empty($form->getErrors()));
    }

    public function Given_TaskDeadlinesSet_When_GetterCalled_Should_ReturnDeadlinesArray()
    {
        $expect = ['12-01-2015 10:00 am', '12-02-2015 10:00 am', '12-03-2015 10:00 am'];
        $post = [
            ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => $expect[0],
            ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => $expect[1],
            ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => $expect[2]
        ];

        $form = new ThreeTaskPenaltyRateForm($post);
        $this->assertEquals($expect, $form->getEntries());
    }

    public function Given_AlternateDeadlineEnabled_When_GetterCalled_Should_ReturnTrue()
    {
        $post = [
            ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
            ThreeTaskPenaltyRateForm::$ALTERNATE_TASK_DEADLINE_KEY => 'on',
            ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
            ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
            ThreeTaskPenaltyRateForm::$TASK_TIME_LIMIT_KEY => '60'
        ];

        $form = new ThreeTaskPenaltyRateForm($post);
        $this->assertTrue($form->getAlternateDeadlineOption());
    }

    public function Given_AlternateDeadlineNotProvided_When_GetterCalled_Should_ReturnFalse()
    {
        $post = [
            ThreeTaskPenaltyRateForm::$NUMBER_SUBJECTS_KEY => '1',
            ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
            ThreeTaskPenaltyRateForm::$TASK_ONE_DEADLINE_KEY => '12-01-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_TWO_DEADLINE_KEY => '12-02-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_THREE_DEADLINE_KEY => '12-03-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
            ThreeTaskPenaltyRateForm::$TASK_TIME_LIMIT_KEY => '60'
        ];

        $form = new ThreeTaskPenaltyRateForm($post);
        $this->assertFalse($form->getAlternateDeadlineOption());
    }
}
