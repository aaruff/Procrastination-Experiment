<?php
class Validate{
	
	/**
	 * Returns true if the value parameter is an integer, 
	 * and if specified is also within the bounds specified by min/max.
	 * @param mixed $value
	 * @param integer $min
	 * @param integer $max
	 * @return boolean
	 */
    public function is_integer($value, $min='', $max =''){
		if(!isset($value) || !is_numeric($value)){
			return false;
		}
		
		if(preg_match('/^[0-9]+$/', $value) != 1){
			return false;
		}
		
		if(!empty($min) || is_numeric($min)){
			if($value < $min){
				return false;
			}
		}
		
		if(!empty($max) || is_numeric($max)){
			if($value > $max){
				return false;
			}
		}
    
		return true;
	}
	
	
	/**
	 * Returns true if the date_time format is:
	 * MM/DD/YYYY HH:MM
	 * or
	 * MM/DD/YYYY HH:MM AM|PM
	 * the format of which is specified by the 
     * format parameter.
     *
	 * @param string $date_time
	 * @param integer $format
	 * @return boolean
	 */
	public function is_date_time($date_time, $format=12){
		if(!isset($date_time) || empty($date_time)){
			return false;
		}
		
		$exploded_date_time = explode(" ", $date_time);
		if(!isset($exploded_date_time[0]) || !isset($exploded_date_time[1])){
			return false;
		}
		
		$date = $exploded_date_time[0];
		$time = $exploded_date_time[1];	
		
		// Date invalid
        if(!$this->is_date($date)){
			return false;
		}
		
		if($format == 12){
			// AM/PM element is empty
			if(empty($exploded_date_time[2])){
				return false;
			}
			
			$time = $time . " " . $exploded_date_time[2];
		}
		
		// 12 hour format invalid
		if($format == 12 && !$this->is_twelve_hour($time)){
			return false;
		}
		
		// 24 hour format invalid
		if($format == 24 && !$this->is_twenty_four_hour($time)){
			return false;
		}
		
		return true;
    }


	/**
	 * Returns true if the date_time format is:
	 * MM/DD/YYYY HH:MM:SS
	 * OR
     * MM/DD/YYYY HH:MM:SS AM|PM
     *
     * AND is set for a time in the future, 
     * relative to the time of execution.
     * 
     * Otherwise false is returned.
     *
	 * @param string $date_time
	 * @param integer $format
	 * @return boolean
	 */
    public function is_future_date_time($date_time, $format=12){
        if(empty($date_time)){
            return false;
        }
        if(!$this->is_date_time($date_time, $format)){
            return false;
        }

        // set the time zone
        date_default_timezone_set(TIME_ZONE);

        // todays date is... 
        $todays_date = date('m/d/Y h:i a');
        
        if(strtotime($date_time) < strtotime($todays_date)){
            return false;
        }

        return true;
    }


	/**
	 * Returns true if the date_time format is:
	 * MM/DD/YYYY HH:MM:SS
	 * OR
     * MM/DD/YYYY HH:MM:SS AM|PM
     *
     * AND is set for a time in the past, 
     * relative to the time of execution.
     * 
     * Otherwise false is returned.
     *
	 * @param string $date_time
	 * @param integer $format
	 * @return boolean
	 */
    public function is_past_date_time($date_time, $format=12){
        if(!$this->is_date_time($date_time, $format)){
            return false;
        }

        // set the time zone
        date_default_timezone_set(TIME_ZONE);

        // todays date is... 
        $todays_date = date('m/d/Y h:i a');

        if(strtotime($date_time) > strtotime($todays_date)){
            return false;
        }

        return true;
    }

    /**
     * Returns false if the date is in the past, otherwise true
     * is returned.
     * @param string $date
     * @return boolean true if $date is in future, otherwise false
     */
    public function is_future_date($date){
        if(!$this->is_date($date)){
            return false;
        }

        // The timezone must always be set before calling the date function
        date_default_timezone_set(TIME_ZONE);

        $todays_date = date('m/d/Y');

        // date is in the past
        if(strtotime($date) < strtotime($todays_date)){
            return false; 
        }

        // date is in the future
        return true;
    }

    /**
     * Returns false if the date is in the past, otherwise true
     * is returned.
     * @param string $date
     * @return boolean true if $date is in future, otherwise false
     */
    public function is_past_date($date){
        if(!$this->is_date($date)){
            return false;
        }

        // The timezone must always be set before calling the date function
        date_default_timezone_set(TIME_ZONE);

        $todays_date = date('m/d/Y');

        // date is in the past
        if(strtotime($date) > strtotime($todays_date)){
            return false; 
        }

        // date is in the future
        return true;
    }

    /**
     * Returns false if the date is in the past or the future, otherwise true
     * is returned.
     * @param string $date
     * @return boolean true if $date is in future, otherwise false
     */
    public function is_same_date($date){
        if(!$this->is_date($date)){
            return false;
        }

        // The timezone must always be set before calling the date function
        date_default_timezone_set(TIME_ZONE);

        $todays_date = date('m/d/Y');

        // date is in the past
        if(strtotime($date) == strtotime($todays_date)){
            return false; 
        }

        // date is in the future
        return true;
    }
	
	/**
	 * Returns true if the date is valid and formated as follows:
	 * MM/DD/YYYY
	 * Where:
	 * MM is an integer between 1-12
	 * DD is an integer between 1-31
	 * YYYY is an integer between 2000 - 2999
	 * Otherwise false is returned.
	 * @param string $date
	 * @return boolean
	 */
	public function is_date($date){
		// Date not set
		if(!isset($date) || empty($date)){
			return false;
		}
		// Date not entered
		$date = explode('/', $date);
		if(empty($date[0]) || empty($date[1]) || empty($date[2])){
			return false;
		}
		
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		// Month format invalid
		if(preg_match('/^((1[0-2])|(0[1-9]))$/', $month) != 1){
			return false;
		}
		// Day format invalid
		if(preg_match('/^((0[1-9])|([1-2][0-9])|30|31)$/', $day) != 1){
			return false;
		}
		// Year format invalid
		if(preg_match('/^2[0-9][0-9][0-9]$/', $year) != 1){
			return false;
        }

		// Invalid calendar date
		if(!checkdate($month, $day, $year)){
			return false;
		}
		
		return true;
	}
	
	/**
	 * Returns false if the entry parameter contains numbers
	 * or punctuation marks.
	 * @param string $entry
	 * @return boolean
	 */
	public function is_alpha($entry){
		if(!isset($entry) || empty($entry)){
			return false;
		}
		
		if(preg_match('/^([a-zA-Z]+[ ]*)+$/', $entry) !== 1){
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Returns true if the time is valid and is of a 12 hour
	 * format, as follows:
	 * HH:MM AM|PM
	 * where:
	 * HH is at most 12 and at least 01
	 * MM is at most 60 and at least 00
	 * otherwise false is returned.
	 * @param string $time
	 * @return boolean
	 */
	public function is_twelve_hour($time){
		if(!isset($time) || empty($time)){
			return false;
		}
		
		$time_values = explode(" ", $time);
		
		// All values not entered
		if(empty($time_values[0]) || empty($time_values[1])){
			return false;
		}
		
		$time = $time_values[0];
		$am_pm = $time_values[1];
		
		$hh_mm_ss = explode(":", $time);
		
		// One or more time values not entered
		if(empty($hh_mm_ss[0]) || empty($hh_mm_ss[1]) || empty($am_pm)){
			return false;
		}
		
		$hours = $hh_mm_ss[0];
		$minutes = $hh_mm_ss[1];
		
		// Invalid hour format
		if(preg_match('/^(0[1-9]|1[0-2])$/', $hours) != 1){
			return false;
		}
		// Invalid minute format
		if(preg_match('/^([0-5][0-9]|60)$/', $minutes) != 1){
			return false;
		}
		// Invalid am/pm format
		if(preg_match('/^((am|AM)|(pm|PM))$/', $am_pm) != 1){
			return false;
		}
		
		return true;
	}
	
	/**
	 * Returns true if the time is valid and is of a 24 hour
	 * format, as follows:
	 * HH:MM
	 * Where:
	 * HH is at most 24 and at least 00
	 * MM is at most 60 and at least 00
	 * @param string $time
	 * @return boolean
	 */
	public function is_twenty_four_hour($time){
		if(!isset($time) || empty($time)){
			return false;
		}
		
		$hh_mm_ss = explode(":", $time);
		
		// One or more time values not entered
		if(empty($hh_mm_ss[0]) || empty($hh_mm_ss[1])){
			return false;
		}
		
		$hours = $hh_mm_ss[0];
		$minutes = $hh_mm_ss[1];
		
		// Invalid hour format
		if(preg_match('/^(0[0-9]|1[0-9]|2[0-4])$/', $hours) != 1){
			return false;
		}
		// Invalid minute format
		if(preg_match('/^([0-5][0-9]|60)$/', $minutes) != 1){
			return false;
		}
		
		return true;
	}
	
	/**
	 * Returns true if the time is formatted as follows:
	 * HH:MM
	 * @param unknown_type $time
	 */
	public function is_hours_minutes($time){
		if(!isset($time) || empty($time)){
			return false;
		}
		
		$hour_min = explode(":", $time);
		
		if(empty($hour_min[0]) && empty($hour_min[1])){
			return false;
		}
		
		return true;
	}
	
	/**
	 * Returns true if the entry is a valid value qualified by
	 * the valid_selections array.
	 * @param string $entry
	 * @param array $valid_selections
	 * @return boolean
	 */
	public function contains_selection($entry, array $valid_selections){
		if(!isset($entry) || empty($entry)){
			return false;
		}
		
		if(!in_array($entry, $valid_selections)){
			return false;
		}
		
		return true;
	}
	
	/**
	 * Returns true if the entry is a number (integer or real number).
	 * Valid format: X or X.X where X is an integer.
	 * @param string $entry
	 * @return boolean
	 */
	public function is_number($entry){
		if(!isset($entry)){
			return false;
		}
		
		if(!is_numeric($entry)){
			return false;
		}
		
		if(is_string($entry)){
			if(preg_match("/^[0-9]*(.)?[0-9]+$/", $entry) != 1){
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Returns true if the email format is not valid,
	 * otherwise false is returned.
	 * @return boolean
	 */
	public function is_email($email){
		if(!isset($email) || empty($email)){
			return false;
		}
		
		$email_format_valid = preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email); 
		if(empty($email_format_valid)){
			return false;
		}
		
		return true;
	}
}
