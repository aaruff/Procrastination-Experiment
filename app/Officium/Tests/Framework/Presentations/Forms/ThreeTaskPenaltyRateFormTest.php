<?php
namespace Framework\Forms;


use Officium\Framework\Presentations\Forms\SessionCreationForm;

class ThreeTaskPenaltyRateFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $post = [
            SessionCreationForm::$SIZE => '1',
            SessionCreationForm::$ADJUSTABLE_DEADLINE => 'on',
            SessionCreationForm::$PENALTY_RATE => '0.5',
            SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            SessionCreationForm::$PAYOFF => '12',
            SessionCreationForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionCreationForm();
        $this->assertTrue($form->validate($post));

        unset($post[SessionCreationForm::$ADJUSTABLE_DEADLINE]);
        $formTwo = new SessionCreationForm($post);
        $this->assertTrue($formTwo->validate());
    }

    /**
     * @test
     */
    public function Given_InvalidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $posts = [
            [
                SessionCreationForm::$SIZE => '1',
            ],
            [
                SessionCreationForm::$SIZE => '1',
                SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            ],
            [
                SessionCreationForm::$SIZE => '1',
                SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            ],
            [
                SessionCreationForm::$SIZE => '1',
                SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionCreationForm::$ADJUSTABLE_DEADLINE => 'on',
            ],
            [
                SessionCreationForm::$SIZE => '1',
                SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionCreationForm::$ADJUSTABLE_DEADLINE => 'on',
                SessionCreationForm::$PENALTY_RATE => '0.5',
            ],
            [
                SessionCreationForm::$SIZE => '1',
                SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionCreationForm::$ADJUSTABLE_DEADLINE => 'on',
                SessionCreationForm::$PENALTY_RATE => '0.5',
                SessionCreationForm::$PAYOFF => '12',
            ],
            [
                SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
                SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
                SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
                SessionCreationForm::$ADJUSTABLE_DEADLINE => 'on',
                SessionCreationForm::$PAYOFF => '12',
                SessionCreationForm::$TASK_TIME_LIMIT => '60'
            ],
        ];

        $form = new SessionCreationForm();
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
            SessionCreationForm::$SIZE => '1',
            SessionCreationForm::$ADJUSTABLE_DEADLINE => 'on',
            SessionCreationForm::$PENALTY_RATE => '0.5',
            SessionCreationForm::$PAYOFF => '12',
            SessionCreationForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionCreationForm();
        $form->validate($post);
        $this->assertTrue( ! empty($form->getErrors()));
    }

    public function Given_TaskDeadlinesSet_When_GetterCalled_Should_ReturnDeadlinesArray()
    {
        $expect = ['12-01-2015 10:00 am', '12-02-2015 10:00 am', '12-03-2015 10:00 am'];
        $post = [
            SessionCreationForm::$TASK_ONE_DEADLINE => $expect[0],
            SessionCreationForm::$TASK_TWO_DEADLINE => $expect[1],
            SessionCreationForm::$TASK_THREE_DEADLINE => $expect[2]
        ];

        $form = new SessionCreationForm($post);
        $this->assertEquals($expect, $form->getEntries());
    }

    public function Given_AlternateDeadlineEnabled_When_GetterCalled_Should_ReturnTrue()
    {
        $post = [
            SessionCreationForm::$SIZE => '1',
            SessionCreationForm::$ADJUSTABLE_DEADLINE => 'on',
            SessionCreationForm::$PENALTY_RATE => '0.5',
            SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            SessionCreationForm::$PAYOFF => '12',
            SessionCreationForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionCreationForm($post);
        $this->assertTrue($form->getAlternateDeadlineOption());
    }

    public function Given_AlternateDeadlineNotProvided_When_GetterCalled_Should_ReturnFalse()
    {
        $post = [
            SessionCreationForm::$SIZE => '1',
            SessionCreationForm::$PENALTY_RATE => '0.5',
            SessionCreationForm::$TASK_ONE_DEADLINE => '12-01-2015 10:00 am',
            SessionCreationForm::$TASK_TWO_DEADLINE => '12-02-2015 10:00 am',
            SessionCreationForm::$TASK_THREE_DEADLINE => '12-03-2015 10:00 am',
            SessionCreationForm::$PAYOFF => '12',
            SessionCreationForm::$TASK_TIME_LIMIT => '60'
        ];

        $form = new SessionCreationForm($post);
        $this->assertFalse($form->getAlternateDeadlineOption());
    }
}
