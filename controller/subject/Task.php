<?php
class Task extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
    private $validate;

    private $num_questions = 150;

    private $post_url;

    private $phrases;
	
	private $form_fields; 
	
    private $form_errors = array('general_error'=>'');

	/**
	 * Initialize instance variables variables, and post_url.
	 * @param string $page
	 */
	public function __construct($page){
		$this->session = new SubjectSession();
		$this->http = new SubjectHTTP();
		$this->db = new TaskModel();
		$this->view = new SubjectView();
		$this->page = $page;
		$this->validate = new FormValidator();
		
		$this->post_url['post_url'] = WEB_ROOT.SUBJECT_DIR.$page;
	}


	/**
	 * Processes email and registration login page requests.
	 */
    public function process_page_request(){		
	    // Not Logged In: Forward to login page
        if(!$this->session->subject_session_active()){
            $this->http->redirect_subject('login');
            return;
        }

        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        if(empty($subject_records)){
            $this->http->redirect_subject('login');
        }

        // Redirect if wrong stage
        if(parent::get_next_stage($subject_records) !== $this->page){
            $this->http->redirect_subject(parent::get_next_stage($subject_records));
            return;
        }

        // Task expired? Redirect subject
        if($this->is_task_expired($subject_records)){
            // Get and Set the next Stage
            $next_stage = $this->get_next_game_status($subject_records['game_status']);
            // Update the Game Status
            $this->db->set_game_stage($next_stage, $subject_records['id']);
            // Get Update Records
            $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());
            // Redirect to next stage
            $this->http->redirect_subject(parent::get_next_stage($subject_records));
        }

		// HTTP GET Request
		if($this->http->is_get_request()){
			$this->process_get_request();
			return;
		}
		
		// HTTP POST Request
		$this->process_post_request();
    }

    private function get_next_game_status($game_status){
        switch($game_status){
        case 'first_task':
            return 'outgoing_survey';
        }
    }
	
	/**
	 * Processes email registration and login authentication
	 * post requests.
	 * @param string $page 
	 */
    protected function process_post_request(){
        $this->phrases = $this->session->get_phrases();

        $this->construct_form_fields();
        $this->set_entries();

        $this->set_errors();

        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        // SESSION or Deadline Error: Phrase not found or Deadline not met -- generate new phases and redisplay the problem
        if(!$this->session->is_phrases() || !$this->within_problem_deadline($subject_records)){
            $this->set_new_phrases($subject_records['id']); 
            
            // Log: New Problem Issued
            $this->db->set_task_log($subject_records['id'], $this->get_current_time(), 'new_problem', $subject_records['game_status']);

            // Return: new problem task 
            $this->view->display($this->page, $this->get_form_fields($subject_records));
            return;
        }

		// Validation Error: Redisplay form
        if($this->errors_found()){	
            // Log: Failed solution attempt
            $this->db->set_task_log($subject_records['id'], $this->get_current_time(), 'failed_solution', $subject_records['game_status']);

            // Return: new problem task 
			$this->view->display($this->page, $this->get_form_fields($subject_records));
			return;
        }

        /* Form solution valid */

        // Log: Successful completion
        $this->db->set_task_log($subject_records['id'], $this->get_current_time(), 'completed_solution', $subject_records['game_status']);

        // Database Update: subject task completion date and time
        $this->db->set_task_completed($subject_records['id'], $subject_records['game_status'], $this->get_current_time());

        // get latest subject values
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        // Database Update: subject game status
        $game_stage = $this->get_next_game_status($subject_records['game_status']);
        $this->db->set_game_stage($game_stage, $subject_records['id']);

        // get latest subject values
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        // Redirect: next stage
		$this->http->redirect_subject(parent::get_next_stage($subject_records));
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
    protected function process_get_request(){
        // Build the form field and errors array 
        $this->construct_form_fields();

        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());
        $this->set_new_phrases($subject_records['id']);
        $this->db->set_task_log($subject_records['id'], $this->get_current_time(), 'new_problem', $subject_records['game_status']);

        // Serve the Task form
		$this->view->display($this->page, $this->get_form_fields($subject_records));
		//$fields = array_merge($this->get_form_fields($subject_records), $this->phrases);
		//$this->view->display($this->page, $fields);
    }

    /**
     * Compiles and returns an array of parameters required for generating the Task form.
     *
     * @param array $subject_records
     * @return array form parameters
     */
    private function get_form_fields($subject_records){
        // form task number 
        $task_number = array('task_number'=>$this->get_task_number($subject_records['game_status']));

        // problem deadline
        $deadline = array('deadline'=>date("m/d/Y h:i a",$this->get_task_deadline($subject_records)));

        // problem image src
        $img_src = array('img_src'=>IMAGE_WEB_DIR.$subject_records['id'].".png");

        // time remaining to complete problem
        $problem_time_limit = array('problem_time_limit'=>date('m/d/Y h:i a', $this->get_problem_deadline($subject_records)));

        return array_merge($this->post_url, $this->form_fields, $this->form_errors, $task_number, $deadline, 
            $problem_time_limit, $img_src);
    }

    /**
     * Returns a timestamp representing the date and time at which a new problem will be issued.
     *
     * @param array $subject_records
     * @return timestamp
     */
    private function get_problem_deadline($subject_records){
        // get the hours and minutes from a HH:MM string
        $hh_mm = explode(":",$subject_records['problem_time_limit']);
        $hours_to_complete = $hh_mm[0];
        $minuts_to_complete = $hh_mm[2];

        $time_problem_issued = $this->db->get_time_last_problem_issued($subject_records['id']);

        $problem_deadline = strtotime("+$hours_to_complete hours", $time_problem_issued);
        $problem_deadline = strtotime("+$minuts_to_complete minutes", $problem_deadline);
        
        return $problem_deadline;
    }

    private function set_new_phrases($subject_id){
        // generate the phrases & image
        $phrases = $this->generate_problem_image($subject_id);

        sort($phrases);

        for($i = 1; $i <= $this->num_questions; ++$i){
            $this->phrases[('phrase_'.$i)] = $phrases[($i-1)];
        }

        // store the phrases in the session array
        $this->session->save('phrases', $this->phrases);
    }

    private function within_problem_deadline($subject_records){
        if($this->get_current_time() > $this->get_problem_deadline($subject_records)){
            return false;
        }
        
        return true;    
    }

    /**
     * Return a timestamp of the date and time this function
     * is called.
     *
     * @return timestamp
     */
    private function get_current_time(){
        // set the time zone
        date_default_timezone_set(TIME_ZONE);
        // todays date is... 
        $todays_date = date('m/d/Y h:i a');

        // returns a timestamp
        return strtotime($todays_date);
    }

    private function is_task_expired($subject_records){
        $current_date_time = $this->get_current_time();
        $task_deadline = $this->get_task_deadline($subject_records);

        if($current_date_time > $task_deadline){
            return true; 
        }

        return false;
    }

    private function get_task_deadline($subject_records){
        if($subject_records['subject_deadline_enabled'] === 'yes'){
            switch($subject_records['game_status']){
            case 'first_task':
                return strtotime($subject_records['first_subject_set_deadline']);
                break;
            case 'second_task':
                return strtotime($subject_records['second_subject_set_deadline']);
                break;
            case 'third_task':
                return strtotime($subject_records['third_subject_set_deadline']);
                break;
            }
        }

        switch($subject_records['game_status']){
        case 'first_task':
            return strtotime($subject_records['first_experimenter_set_deadline']);
            break;
        case 'second_task':
            return strtotime($subject_records['second_experimenter_set_deadline']);
            break;
        case 'third_task':
            return strtotime($subject_records['third_experimenter_set_deadline']);
            break;
        }
    }

    private function get_task_number($game_status){
        switch($game_status){
        case 'first_task':
            return 1; 
            break;
        case 'second_task':
            return 2; 
            break;
        case 'third_task':
            return 3; 
            break;
        }
    }
    

    private function construct_form_fields(){
        for($i = 1; $i <= $this->num_questions; ++$i){
            $this->form_fields[('phrase_'.$i)] = '';
        }
    }

	/**
	 * Places form entries into the form_fields instance array variables. 
	 */
    protected function set_entries(){
        foreach($this->form_fields as $key=>$value){
            // set post values with proper key names  
            if(isset($_POST[$key])){
                $this->form_fields[$key] = $_POST[$key];
            }
        }
	}
	
	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param subjectHTML $html
	 */
    protected function set_errors(){
        // compare answer to phrases
        foreach($this->phrases as $key=>$phrase){
            if($phrase !== $this->form_fields[$key]){
                $this->form_errors['general_error'] = 'An error has been found in your submission. Please try again';
                return;
            }
        }
	}
	
	/**
	 * Returns true if an error is found
	 * in the form_errors array, otherwise 
	 * false is returned.
	 * @return boolean
	 */
    protected function errors_found(){
        if(!empty($this->form_errors['general_error'])){
            return true;
        }

        return false;
    }

    /**
     * Generates the problem image, saves it in the "img" directory,
     * and returns the phrases generated.
     * @param $subject_id
     * @return array
     */
    private function generate_problem_image($subject_id){
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

	/**
	 * 
	 * @param $syllables
	 * @param $use_prefix
	 * @return unknown_type
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
