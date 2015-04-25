<?php
namespace Framework\Forms;


use Officium\Framework\Presentations\Forms\SessionForm;

class ThreeTaskPenaltyRateFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $post = [
            SessionForm::$SIZE => '1',
            SessionForm::$ADJUSTABLE_DEADLINE => 'on',
            SessionForm::$PENALTY_RATE => '0.5',
            SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            SessionForm::$PAYOFF => '12',
            SessionForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionForm();
        $this->assertTrue($form->validate($post));

        unset($post[SessionForm::$ADJUSTABLE_DEADLINE]);
        $formTwo = new SessionForm($post);
        $this->assertTrue($formTwo->validate());
    }

    /**
     * @test
     */
    public function Given_InvalidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $posts = [
            [
                SessionForm::$SIZE => '1',
            ],
            [
                SessionForm::$SIZE => '1',
                SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            ],
            [
                SessionForm::$SIZE => '1',
                SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            ],
            [
                SessionForm::$SIZE => '1',
                SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionForm::$ADJUSTABLE_DEADLINE => 'on',
            ],
            [
                SessionForm::$SIZE => '1',
                SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionForm::$ADJUSTABLE_DEADLINE => 'on',
                SessionForm::$PENALTY_RATE => '0.5',
            ],
            [
                SessionForm::$SIZE => '1',
                SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionForm::$ADJUSTABLE_DEADLINE => 'on',
                SessionForm::$PENALTY_RATE => '0.5',
                SessionForm::$PAYOFF => '12',
            ],
            [
                SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionForm::$ADJUSTABLE_DEADLINE => 'on',
                SessionForm::$PAYOFF => '12',
                SessionForm::$TASK_TIME_LIMIT => '60'
            ],
        ];

        $form = new SessionForm();
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
            SessionForm::$SIZE => '1',
            SessionForm::$ADJUSTABLE_DEADLINE => 'on',
            SessionForm::$PENALTY_RATE => '0.5',
            SessionForm::$PAYOFF => '12',
            SessionForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionForm();
        $form->validate($post);
        $this->assertTrue( ! empty($form->getErrors()));
    }

    public function Given_TaskDeadlinesSet_When_GetterCalled_Should_ReturnDeadlinesArray()
    {
        $expect = ['12-01-2015 10:00 am', '12-02-2015 10:00 am', '12-03-2015 10:00 am'];
        $post = [
            SessionForm::$TASK_ONE_DEADLINE => $expect[0],
            SessionForm::$TASK_TWO_DEADLINE => $expect[1],
            SessionForm::$TASK_THREE_DEADLINE => $expect[2]
        ];

        $form = new SessionForm($post);
        $this->assertEquals($expect, $form->getEntries());
    }

    public function Given_AlternateDeadlineEnabled_When_GetterCalled_Should_ReturnTrue()
    {
        $post = [
            SessionForm::$SIZE => '1',
            SessionForm::$ADJUSTABLE_DEADLINE => 'on',
            SessionForm::$PENALTY_RATE => '0.5',
            SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            SessionForm::$PAYOFF => '12',
            SessionForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionForm($post);
        $this->assertTrue($form->getSecondaryDeadlineEnabled());
    }

    public function Given_AlternateDeadlineNotProvided_When_GetterCalled_Should_ReturnFalse()
    {
        $post = [
            SessionForm::$SIZE => '1',
            SessionForm::$PENALTY_RATE => '0.5',
            SessionForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            SessionForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            SessionForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            SessionForm::$PAYOFF => '12',
            SessionForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionForm($post);
        $this->assertFalse($form->getSecondaryDeadlineEnabled());
    }
}
