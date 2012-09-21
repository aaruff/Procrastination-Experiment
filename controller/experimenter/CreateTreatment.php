<?php
class CreateTreatment{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
	private $validate;
	
	private $subject_form_keys = array('treatment_id', 'subject_deadline_enabled', 'first_experimenter_set_deadline',
		'problem_time_limit', 'enable_reminder_notification', 'reminder_delivery_time', 'reminder_cost');
	
	private $form_fields = array(
		'number_subjects'=>'',
		'treatment_id'=>'',
		'subject_deadline_enabled'=>'',
		'first_experimenter_set_deadline'=>'',
		'problem_time_limit'=>'',
		'enable_reminder_notification'=>'',
		'reminder_delivery_time'=>'',
		'reminder_cost'=>''
		);
		
	private $form_errors = array(
		'number_subjects_error'=>'',
		'treatment_id_error'=>'',
		'subject_deadline_enabled_error'=>'',
		'first_experimenter_set_deadline_error'=>'',
		'problem_time_limit_error'=>'',
		'enable_reminder_notification_error'=>'',
		'reminder_delivery_time_error'=>'',
		'reminder_cost_error'=>''
	);
	
	/**
	 * Initialize instance variables variables, and post_url.
	 * @param string $page
	 */
	public function __construct($page){
		$this->session = new ExperimenterSession();
		$this->http = new ExperimenterHTTP();
		$this->db = new TreatmentCreationModel();
		$this->view = new ExperimenterView();
		$this->validate = new CreateTreatmentValidation();
		$this->page = $page;
		
		$this->form_fields['post_url'] = WEB_ROOT.EXPERIMENTER_DIR.$page;
	}
	
	/**
	 * Processes email and registration login page requests.
	 */
	public function process_page_request(){		
		
		// Experimenter Session Not Active
		if(!$this->session->experimenter_session_active()){	
			$this->http->redirect_experimenter('login');
			return;
		}
		
		// HTTP GET Request
		if($this->http->is_get_request()){
			$this->process_get_request();
			return;
		}
		
		// HTTP POST Request
		$this->process_post_request();
		return;
	}
	
	/**
	 * Processes email registration and login authentication
	 * post requests.
	 * @param string $page 
	 */
	private function process_post_request(){
		$this->set_form_fields();
		$this->set_errors();
		
		// Form errors found
		if($this->errors_found()){	
			$this->view->display($this->page, array_merge($this->form_fields, $this->form_errors));
			return;
		}	
		
		// Add subject accounts to the database
		$subjects = $this->create_subject_accounts();	
		foreach( $subjects as $subject){
			$result = $this->db->add_subject($subject);
		}
		
		$this->http->redirect_experimenter("viewSubjects");
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
	private function process_get_request(){
		$this->form_fields['treatment_id'] = $this->db->get_next_available_treatment_id();
		
		// display form entries and errors, specified by the page argument
		$this->view->display($this->page, array_merge($this->form_fields, $this->form_errors));
	}
	
	/**
	 * Places the form entries into the form_fields instance
	 * variable (array).
	 */
	private function set_form_fields(){
		$valid_keys = array_keys($this->form_fields);
		foreach($valid_keys as $key){
			if(isset($_POST[$key]) && !empty($_POST[$key])){
				$this->form_fields[$key] = trim($_POST[$key]);
			}
		}
	}
	
	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param experimenterHTML $html
	 */
	private function set_errors(){
		// Invalid number of subjects
		if(!$this->validate->is_integer($this->form_fields['number_subjects'], 1)){
			$this->form_errors['number_subjects_error'] = "A positive integer value is required.";
		}
		// Treatment ID invalid
		if(!$this->validate->is_integer($this->form_fields['treatment_id'], 1)){
			$this->form_errors['treatment_id_error'] = "A positive integer value is required.";
		}
		// Invalid subject deadline setting
		if(!$this->validate->contains_selection($this->form_fields['subject_deadline_enabled'], array('yes', 'no'))){
			$this->form_errors['subject_deadline_enabled_error'] = "A selection is required.";
		}
		// Incorrectly formatted first deadline
		if(!$this->validate->is_date_time($this->form_fields['first_experimenter_set_deadline'])){
			$this->form_errors['first_experimenter_set_deadline_error'] = "Invalid entry";
		}
		// Invalid timelimit format
		if(!$this->validate->is_hours_minutes($this->form_fields['problem_time_limit'])){
			$this->form_errors['problem_time_limit_error'] = "Invalid entry";
		}
		// Invalid reminder selection
		if(!$this->validate->contains_selection($this->form_fields['enable_reminder_notification'], array('yes', 'no'))){
			$this->form_errors['enable_reminder_notification_error'] = "reminder setting required";
		}
		// Reminder on, reminder delivery time not set
		if($this->form_fields['enable_reminder_notification'] === 'yes' && !$this->validate->is_twelve_hour($this->form_fields['reminder_delivery_time'])){
			$this->form_errors['reminder_delivery_time_error'] = "Invalid time format";
        }
        if(!empty($this->form_fields['reminder_cost'])){
           if(!$this->validate->is_number($this->form_fields['reminder_cost']) && 
                $this->form_fields['enable_reminder_notification'] === 'yes'){
                $this->form_errors['reminder_cost_error'] = "Reminder cost value required";
           }
        }
	}
	
	/**
	 * Returns true if an error is found
	 * in the form_errors array, otherwise 
	 * false is returned.
	 * @return boolean
	 */
	private function errors_found(){
		foreach($this->form_errors as $key=>$value){
			if(!empty($value)){
				return true;
			}
		}
		
		return false;
	}
		
	/**
	 * Creates subjects -- specified in the $form_entries['num_participants'] --
	 * and sets their treatments using an Experimenter object.
	 * @param Experimenter $experimenter
	 * @param array $form_entries
	 */
	private function create_subject_accounts(){
		// Generate the number of subjects accounts specified
		for($i = 0; $i < $this->form_fields['number_subjects']; $i++){
			$login = $this->generate_subject_login();
			$password = $login . rand(0,1000);
			
			$subject_accounts[$i] = array(
				'login'=>$login,
				'password'=>$password
			);

			foreach($this->subject_form_keys as $key){
				$subject_accounts[$i][$key] = $this->form_fields[$key];
			}
		}
		
		return $subject_accounts;
	}
	
	/**
	 * generates subject passwords 
	 *
	 * @param integer $syllables
	 * @param boolean $use_prefix
	 * @return string password
	 */
	private function generate_subject_login($syllables = 3){
	
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
	                        'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'q');
	
	    // get a random suffix
	    $login_suffix = $suffix[rand(0, (count($suffix)-1))];
	
	    // for each number of sylllables 
	    for($i=0; $i<$syllables; $i++) {
	        $doubles = array('n', 'm', 't', 's');
	        
	        // select a random consonant
	        $consonant = $consonants[rand(0, (count($consonants)-1))];
	        
	        // If the constonant is in the doubles array double it with 1/3 probability
	        if (in_array($consonant, $doubles)&&($i!=0)) { // maybe double it
	            if (rand(0, 2) == 1) // 33% probability
	                $consonant .= $consonant;
	        }
	        
	        // append the consonant to the login
	        $login = '';
	        $login .= $consonant;
	        
	        // selecting random vowel
	        $login .= $vowels[rand(0, (count($vowels)-1))];
	
	        if ($i == $syllables - 1){ // if suffix begin with vovel
	            if (in_array($login_suffix[0], $vowels)){ // add one more consonant 
	                $login .= $consonants[rand(0, (count($consonants)-1))];
	            }
	        }

	    }
	
	    // selecting random suffix
	    $login .= $login_suffix;
	
	    return $login;
	}	

}
