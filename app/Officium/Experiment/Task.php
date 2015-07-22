<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    private static $DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */
    /**
     * Sets the task deadline.
     *
     * @param \DateTime $deadline
     */
    public function setPrimaryDeadline(\DateTime $deadline)
    {
        $this->primary_deadline = $deadline->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * Time to zero payoff in hours and minutes represented as a floating point number.
     * @return float
     */
    public function timeToZeroPayoff()
    {
        return $this->getPayoff()/$this->getPenaltyRate();
    }

    /**
     * @return \DateTime
     */
    public function getDeadline()
    {
        return \DateTime::createFromFormat(self::$DB_DATE_TIME_FORMAT, $this->primary_deadline);
    }

    /**
     * Sets the treatment ID.
     *
     * @param int $treatmentId
     */
    public function setTreatmentId($treatmentId)
    {
        $this->treatment_id = $treatmentId;
    }

    /**
     * Sets the task number.
     *
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Returns the task number.
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the flag which indicates if subject enabled deadlines are enabled.
     *
     * @param $enabled
     */
    public function setSecondaryDeadlineEnabled($enabled)
    {
        $this->secondary_deadline_enabled = $enabled;
    }

    /**
     * @return bool
     */
    public function isSubjectDeadlineEnabled()
    {
        return $this->secondary_deadline_enabled == true;
    }

    /**
     * Set the flag which indicates if the penalty rate is used in this treatment.
     *
     * @param $enabled
     */
    public function setPenaltyRateEnabled($enabled)
    {
        $this->penalty_rate_enabled = $enabled;
    }

    /**
     * Hours to complete task
     * @return int
     */
    public function getTimeLimit()
    {
        return $this->time_limit;
    }

    /**
     * Sets the time limit allotted to this task.
     *
     * @param int $timeLimit
     */
    public function setTimeLimit($timeLimit)
    {
        $this->time_limit = $timeLimit;
    }

    /**
     * Sets the task payoff.
     *
     * @param $payoff
     */
    public function setPayoff($payoff)
    {
        $this->payoff = $payoff;
    }

    /**

     * @return float
     */
    public function getPayoff()
    {
        return $this->payoff;
    }

    /**
     * Sets the penalty rate that reduces the payoff after the deadline has passed.
     *
     * @param $penaltyRate
     */
    public function setPenaltyRate($penaltyRate)
    {
        $this->penalty_rate = $penaltyRate;
    }

    /**
     * @return float
     */
    public function getPenaltyRate()
    {
        return $this->penalty_rate;
    }

    /**
     * Generates the problem image, saves it in the "img" directory,
     * and returns the phrases generated.
     * @param $subject_id
     * @return array
     */
    public function generate_problem_image($subject_id){
        $im = imagecreate(650, 1100);
        $green = imagecolorallocate($im, 250, 250, 250);
        $black = imagecolorallocate($im, 0, 0, 0);
        $size = 8;

        imagefill($im, 0, 0, $green);

        // Initial x,y coordinates
        $x = 90;
        $y = 60;
        $deg = 10;
        $phrases = array();
        // rotate and draw a random text string
        // upper bound was 50 ($column < 50)
        for($column=0, $k = 0; $column < $this->num_questions/2; $column++, $x = (($x+120) % 900), $deg = (rand(0, 180))){

            // When the 5th column has been reached moved to the next row
            if($column%5 == 0 && $column != 0){
                $y+=70;
                $x=90;
            }
            do{
                $word = $this->generate_phrase();
            } while(in_array($word, $phrases));

            $phrases[$k] = $word;
            $k++;

            //imagettftext($im, $size, $deg, $x, $y, $black, "FreeSans.ttf",$word);
            imagettftext($im, $size, $deg, $x, $y, $black, TASK_FONT,$word);

            do{
                $word = $this->generate_phrase();
            } while(in_array($word, $phrases));

            $phrases[$k] = $word;
            $k++;

            //array_push($phrases,$word);
            if($deg < 40){
                imagettftext($im, $size, $deg+30, $x-50, $y, $black, TASK_FONT,$word);
            }
            elseif($deg > 130){
                imagettftext($im, $size, $deg-40, $x+50, $y, $black, TASK_FONT,$word);
            }
            else{
                imagettftext($im, $size, $deg+30, $x+50, $y, $black, TASK_FONT,$word);
            }
        }

        imagepng($im, IMAGE_DIR.$subject_id. ".png");
        //imagepng($im);
        imagedestroy($im);
        chmod(IMAGE_DIR.$subject_id.".png",0644);
        return $phrases;
    }

    /* ------------------------------------------------------------------------------------------
     *                                   Private
     * ------------------------------------------------------------------------------------------ */

    /**
     *
     * @param $syllables
     * @param $use_prefix
     * @return string
     */
    private function generate_phrase($syllables = 1, $use_prefix = false){
        // 20 prefixes
        $prefix = array('aero', 'anti', 'auto', 'bi', 'bio',
            'cine', 'deca', 'demo', 'dyna', 'eco',
            'ergo', 'geo', 'gyno', 'hypo', 'kilo',
            'mega', 'tera', 'mini', 'nano', 'duo');

        // 10 random suffixes
        $suffix = array('dom', 'ity', 'ment', 'sion', 'ness',
            'ence', 'er', 'ist', 'tion', 'or');

        // 8 vowel sounds
        $vowels = array('a', 'o', 'e', 'i', 'y', 'u', 'ou', 'oo');

        // 20 random consonants
        $consonants = array('w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j',
            'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'qu');

        $password = ($use_prefix)? $this->get_random_position($prefix) : '';
        $password_suffix = $this->get_random_position($suffix);

        for($i=0; $i<$syllables; $i++)
        {
            // selecting random consonant
            $doubles = array('n', 'm', 't', 's');
            $c = $this->get_random_position($consonants);
            if (in_array($c, $doubles) && ($i != 0)) { // maybe double it
                if (rand(0, 2) == 1){ // 33% probability
                    $c .= $c;
                }
            }
            $password .= $c;

            // selecting random vowel
            $password .= $this->get_random_position($vowels);

            if ($i == $syllables - 1){ // if suffix begin with vovel
                if (in_array($password_suffix[0], $vowels)){ // add one more consonant
                    $password .= $this->get_random_position($consonants);
                }
            }
        }

        // selecting random suffix
        $password .= $password_suffix;

        return $password;
    }
    private function get_random_position($str_arr){
        $str_arr_size = sizeof($str_arr);
        return $str_arr[rand(0, $str_arr_size-1)];
    }
}