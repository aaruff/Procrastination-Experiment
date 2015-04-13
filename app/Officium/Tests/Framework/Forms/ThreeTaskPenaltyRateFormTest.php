<?php
namespace Framework\Forms;


use Officium\Framework\HTTP\PostFilter;
use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;

class ThreeTaskPenaltyRateFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $post = [
            ThreeTaskPenaltyRateForm::$SESSION_SIZE_KEY => '1',
            ThreeTaskPenaltyRateForm::$ADJUSTABLE_SUBJECT_DEADLINE_KEY => 'on',
            ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
            ThreeTaskPenaltyRateForm::$TASK_ONE_KEY => '12-01-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_TWO_KEY => '12-02-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$TASK_THREE_KEY => '12-03-2015 10:00 am',
            ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
            ThreeTaskPenaltyRateForm::$TASK_TIME_LIMIT_KEY => '60'
        ];

        $form = new ThreeTaskPenaltyRateForm();
        $this->assertTrue($form->validate($post));
    }

    /**
     * @test
     */
    public function Given_InvalidEntriesProvided_When_Validated_Should_ReturnTrue()
    {
        $posts = [
            [
            ThreeTaskPenaltyRateForm::$SESSION_SIZE_KEY => '1'
            ],
            [
            ThreeTaskPenaltyRateForm::$SESSION_SIZE_KEY => '1',
            ThreeTaskPenaltyRateForm::$ADJUSTABLE_SUBJECT_DEADLINE_KEY => 'on',
            ThreeTaskPenaltyRateForm::$PENALTY_RATE_KEY => '0.5',
            ThreeTaskPenaltyRateForm::$PAYOFF_KEY => '12',
            ThreeTaskPenaltyRateForm::$TASK_TIME_LIMIT_KEY => '60'
            ]
        ];

        $form = new ThreeTaskPenaltyRateForm();
        foreach ($posts as $post) {
            $this->assertFalse($form->validate(PostFilter::filterEntries($post, $form->getFormKeys())));
        }
    }
}
