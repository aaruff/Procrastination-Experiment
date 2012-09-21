<?php
class FormValidator{

    private $validate;

    public function __construct(){
        $this->validate = new Validate();
    }
    /**
     * Returns an array of form keys with corresponding errors if found.
     * TODO: Handle checkboxes.
     * TODO: throw an exception if an non-existent function is is in $validation_rules.
     * TODO: move prepending of 'error_' to entries key to caller function. 
     *
     * @param array $entries
     * @param array $validate_rules
     * @return array
     */
    public function validate_entries(array $entries, array $validation_rules){
        if(empty($entries) || empty($validation_rules)){
           return false; 
        }

        /* 
         * Call each validation function specified in validation_rules array,
         * and place any error messages that might be generated in $error_messages.
         */
        foreach($validation_rules as $form_key=>$validation_function){

            // validate rules of the form validation_function[param,param]
            if(preg_match('/^[a-zA-Z]+(_[a-zA-Z]+)*\[[ ]*([a-zA-Z]|[0-9])+(,[ ]*([a-zA-Z]|[0-9])+)*[ ]*]$/',$validation_function) === 1){

                // split the validation rule starting from first [
                $split_rule = explode("[", $validation_function);

                $validation_function = sprintf("FormValidator::%s", trim($split_rule[0]));

                // trim and convert the parameter string to an array
                $validation_parameters = $this->convert_param_string_to_array(preg_replace("/\]/", "", $split_rule[1]));
                

                // If a non existent function is call ALL HELL BRAKES LOOSE!! 
                if(!method_exists('FormValidator',trim($split_rule[0]))){
                    return ;
                }

                // prepare the validation functions parameters to be used with call_user_funct_array
                $parameters = array_merge(array($entries[$form_key]), $validation_parameters);

                $error_messages['error_'.$form_key] = call_user_func_array($validation_function, $parameters);
            }
            else {  // validation function has only one parameter set 
                $error_messages['error_'.$form_key] = $this->{$validation_function}($entries[$form_key]);
            }
        }

        return $error_messages;
    }

    /**
     * Converts a parameter string to an array, and trims
     * the leading and trailing spaces. An empty array is
     * returned if the param parameter is not set or empty.
     * @param string $param_str.
     * @return array
     */   
    private function convert_param_string_to_array($param_str=''){
        $validation_parameters = explode(",", $param_str);

        foreach($validation_parameters as $key=>$parameter){
            $validation_parameters[$key] = trim($parameter);
        }   
        return $validation_parameters;
    }
    

    /**
     * Returns a error string if the entry is not an integer, and
     * within the boundries if set, otherwise true is returned
     * @param string $entry
     * @param string min
     * @param string max
     */
    public function is_integer($entry, $min='', $max=''){
        //return an error string if the entry is not an integer
        if(!$this->validate->is_integer($entry, $min, $max)){
            return "Integer Required";  
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not a properly formatted 
     * Date and time string, otherwise an empty string is returned.
     *
     * DATE TIME FORMAT: MM/DD/YYYY HH:MM AM|PM
     * OR
     * DATE TIME FORMAT: MM/DD/YYYY HH:MM 
     *
     * Note: HH can be a 12 hour or 24 hour format specified by
     * the $format parameter (12, or 24).
     *
     * @param string $date_time
     * @param integer $format
     * @return string error string, or empty string
     */
    public function is_date_time($date_time, $format=12){
        $date_times = explode(",", $date_time);

       // validate each date-time if there is more than one 
        if(count($date_times) > 1){
            $valid_result = true;
            foreach($date_times as $dt){
                $valid_result &= $this->validate->is_date_time($dt);
            }

            // invalid format found
           if(!$valid_result){
                return 'Valid date/time required';
           }
            
            return ''; // valid result

        }
        if(!$this->validate->is_date_time($date_time, $format)){
            return "Valid date/time required";
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not a properly formatted 
     * Date and time string, or lies in the past.
     *
     * VALID DATE TIME FORMAT: MM/DD/YYYY HH:MM AM|PM
     * OR
     * VALID DATE TIME FORMAT: MM/DD/YYYY HH:MM 
     *
     * Note: HH can be a 12 hour or 24 hour format specified by
     * the $format parameter (12, or 24).
     *
     * Otherwise an empty string is returned.
     *
     * @param string $date_time
     * @param integer $format
     * @return string error string, or empty string
     */
    public function is_future_date_time($date_time, $format=12){
        $date_times = explode(",", $date_time);

       // validate each date-time if there is more than one 
        if(count($date_times) > 1){
            $valid_result = true;
            foreach($date_times as $dt){
                $valid_result &= $this->validate->is_future_date_time(trim($dt), $format);
            }

            // invalid format found
           if(!$valid_result){
                return 'Valid date and time required';
           }
            
            return ''; // valid result

        }
        if(!$this->validate->is_future_date_time($date_time, $format)){
            return 'Valid date and time required';
        }
        return '';
    }
    
    /**
     * Returns an error string if the entry is not a properly formatted date string
     * or a series of date strings that all lie in the future relative to the time
     * of execution.
     *
     * Otherwise an empty string is returned.
     *
     * DATE TIME FORMAT: MM/DD/YYYY 
     *
     * @param string $date
     * @return string error string, or empty string
     */
    public function is_future_date($date){
       
        $dates = explode(",", $date);
        // validate each date if more than one and return results
        if(count($dates) > 1){
            $valid_result = true;
            foreach($dates as $date_entry){
                $valid_result &= $this->validate->is_future_date(trim($date_entry));
            }
            
            if(!$valid_result){
                return "Invalid Date";
            }

            return '';
        }

        if(!$this->validate->is_future_date($date)){
            return "Invalid Date";
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not a properly formatted date string
     * or a series of date strings that all lie in the future relative to the time
     * of execution.
     *
     * Otherwise an empty string is returned.
     *
     * DATE TIME FORMAT: MM/DD/YYYY 
     *
     * @param string $date
     * @return string error string, or empty string
     */
    public function is_past_date($date){
       
        $dates = explode(",", $date);

        // validate each date if more than one and return results
        if(count($dates) > 1){
            $valid_result = true;
            foreach($dates as $date_entry){
                $valid_result &= $this->validate->is_past_date(trim($date_entry));
            }
            
            if(!$valid_result){
                return "MM/DD/YY required";
            }
            return '';
        }

        if(!$this->validate->is_past_date($date)){
            return "MM/DD/YY required";
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not a properly formatted 
     * Date and time string, or lies in the future.
     *
     * VALID DATE TIME FORMAT: MM/DD/YYYY HH:MM AM|PM
     * OR
     * VALID DATE TIME FORMAT: MM/DD/YYYY HH:MM 
     *
     * Note: HH can be a 12 hour or 24 hour format specified by
     * the $format parameter (12, or 24).
     *
     * Otherwise an empty string is returned.
     *
     * @param string $date_time
     * @param integer $format
     * @return string error string, or empty string
     */
    public function is_past_date_time($date_time, $format=12){
        $date_times = explode(",", $date_time);

       // validate each date-time if there is more than one 
        if(count($date_times) > 1){
            $valid_result = true;
            foreach($date_times as $dt){
                $valid_result &= $this->validate->is_past_date_time($dt);
            }

            // invalid format found
           if(!$valid_result){
                return 'MM/DD/YYYY HH:MM AM|PM required';
           }
            
            return ''; // valid result

        }
        if(!$this->validate->is_past_date_time($date_time, $format)){
            return 'MM/DD/YYYY HH:MM AM|PM required';
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not a properly formatted date string
     * or a series of date strings, otherwise an empty string is returned.
     *
     * DATE TIME FORMAT: MM/DD/YYYY 
     *
     * @param string $date
     * @return string error string, or empty string
     */
    public function is_date($date){
       
        $dates = explode(",", $date);

        // validate each date if more than one and return results
        if(count($dates) > 1){
            $valid_result = true;
            foreach($dates as $date_entry){
                $valid_result &= $this->validate->is_date(trim($date_entry));
            }
            
            if(!$valid_result){
                return "Invalid Date";
            }

            return '';
        }

        if(!$this->validate->is_date($date)){
            return "Invalid Date";
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not a properly formatted alphabetical 
     * string otherwise an empty string is returned.
     *
     * ALPHABETICAL STRING FORMAT: [a-zA-Z]+
     *
     * @param string $alphabetical_string
     * @return string error string, or empty string
     */
    public function is_alpha($alphabetical_string){
        if(!$this->validate->is_alpha($alphabetical_string)){
            return "Alphabetical text only";
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not a properly formatted 12 hour
     * time string, otherwise an empty string is returned.
     *
     * TIME STRING FORMAT: HH:MM AM|PM
     * @param string $time
     * @return string error string, or empty string
     */
    public function is_twelve_hour($time){
        if(!$this->validate->is_twelve_hour($time)){
            return "Time must be formatted as HH:MM AM|PM";
        }
        return '';
    }

    /**
     * Returns an error string if the entry is not properly formatted 24 hour
     * time string. otherwise an empty string is returned.
     *
     * 24 HOUR TIME STRING: HH:MM
     *
     * @param string $time
     * @return string error string, or empty string
     */
    public function is_twenty_four_hour($time){
        if(!$this->validate->is_twenty_four_hour($time)){
            return 'The time must be formatted as HH:MM:SS (HH is 24hour format)';
        }
        return '';
    }
    
    /**
     * Returns an error string if the entry is not a poroperly formatted time
     * string, otherwise an empty string is returned.
     *
     * TIME FORMAT: HH:MM
     *
     * @param string $time
     * @return string error string, or empty string.
     */
    public function is_hours_minutes($time){
        if(!$this->validate->is_hours_minutes($time)){
            return "HH:SS required";
        }
        return '';
    }

    /**
     * Returns an error if the entry is not found in the valid_selections
     * array, otherwise an empty string is returned.
     * 
     * Note: contains selections can take an unknown number of valid
     * selection fields. The parameters for the selection are retrieved
     * via func_get_args().
     *
     * @return string error string, or an empty string
     */
    public function contains_selection(){
       $parameters = func_get_args();
       $entry = $parameters[0];
       $valid_selections = array_slice($parameters, 1);
        if(!in_array($entry, $valid_selections)){
            return 'A valid selection must be made';
        }
        return '';
    }

   /**
    * Returns an error if the entry is not a number, otherwise an
    * empty string is returned.
    * @param string $entry
    * @return string error string, or an empty string
    */ 
    public function is_number($entry){
        if(!$this->validate->is_number($entry)){
            return 'Number required';
        }
        return '';
    }

   /**
    * Returns a nerror string if the entry is not a valid email format.
    * @param $email
    * @return string error string, or an empty string
    */ 
   public function is_email($email){
        if(!$this->validate->is_email($email)){
            return 'Email required';
        }
        return '';
    }


}
