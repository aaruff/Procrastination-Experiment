<?php

namespace Officium\Experiment;

class Problem
{
    private $subjectId;
    private $phrases;
    private $timeIssued;
    private $fileName;

    public function __construct($subjectId)
    {
        $this->subjectId = $subjectId;
        $this->generate_image();
    }

    /**
     * @return \DateTime
     */
    public function getTimeIssued()
    {
        return $this->timeIssued;
    }

    /**
     * @return string[]
     */
    public function getPhrases()
    {
        return $this->phrases;
    }

    public function getImageFileName()
    {
        return $this->fileName;
    }

    /**
     * Generates the problem image, saves it in the "img" directory,
     * and returns the phrases generated.
     * @param $numPhrases
     */
    private function generate_image($numPhrases = 150){
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
        for($column=0, $k = 0; $column < $numPhrases/2; $column++, $x = (($x+120) % 900), $deg = (rand(0, 180))){

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
            imagettftext($im, $size, $deg, $x, $y, $black, getenv('PROBLEM_FONT'),$word);

            do{
                $word = $this->generate_phrase();
            } while(in_array($word, $phrases));

            $phrases[$k] = $word;
            $k++;

            //array_push($phrases,$word);
            if($deg < 40){
                imagettftext($im, $size, $deg+30, $x-50, $y, $black, getenv('PROBLEM_FONT'),$word);
            }
            elseif($deg > 130){
                imagettftext($im, $size, $deg-40, $x+50, $y, $black, getenv('PROBLEM_FONT'),$word);
            }
            else{
                imagettftext($im, $size, $deg+30, $x+50, $y, $black, getenv('PROBLEM_FONT'),$word);
            }
        }

        $this->fileName = $this->subjectId. ".png";
        $this->phrases = $phrases;
        $this->timeIssued = new \DateTime('now');

        imagepng($im, getenv('IMAGE_DIR') . $this->fileName);

        //imagepng($im);
        imagedestroy($im);
        chmod(getenv('IMAGE_DIR') . $this->fileName, 0644);
    }

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

    /**
     * @return mixed
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    /**
     * @param mixed $subjectId
     */
    public function setSubjectId($subjectId)
    {
        $this->subjectId = $subjectId;
    }
}