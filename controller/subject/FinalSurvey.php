<?php
class FinalSurvey extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
    private $validate;

    private $post_url;
	
	private $form_fields = array(
        'question_20'=>'',
        'question_20_sub_1'=>'',
		'question_21'=>'',
        'question_21_sub_1'=>'',
		'question_22'=>'',
        'question_22_sub_1'=>'',
		'question_23'=>'',
        'question_23_sub_1'=>'',
		'question_24'=>'',
        'question_24_sub_1'=>'',
		'question_25'=>'',
        'question_25_sub_1'=>'',
		'question_26'=>'',
        'question_26_sub_1'=>'',
		'question_27'=>'',
		'question_28'=>'',
		'question_29'=>'',
    );

    private $first_survey_answers = array(
        'question_4_sub_1'=>'',
        'question_4_sub_2'=>'',
        'question_4_sub_3'=>'',
        'question_7_sub_1'=>'',
        'question_7_sub_2'=>'',
        'question_7_sub_3'=>'',
        'question_7_sub_4'=>''
    );

	private $form_errors = array(
		'error_question_20'=>'',
		'error_question_20_sub_1'=>'',
		'error_question_21'=>'',
		'error_question_21_sub_1'=>'',
		'error_question_22'=>'',
		'error_question_22_sub_1'=>'',
		'error_question_23'=>'',
		'error_question_23_sub_1'=>'',
		'error_question_24'=>'',
		'error_question_24_sub_1'=>'',
		'error_question_25'=>'',
		'error_question_25_sub_1'=>'',
		'error_question_26'=>'',
		'error_question_26_sub_1'=>'',
		'error_question_27'=>'',
		'error_question_28'=>'',
		'error_question_29'=>''
	);
	
	/**
	 * Initialize instance variables variables, and post_url.
	 * @param string $page
	 */
	public function __construct($page){
		$this->session = new SubjectSession();
		$this->http = new SubjectHTTP();
		$this->db = new SurveyModel();
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
        }

        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        // Redirect if wrong stage
        if(parent::get_next_stage($subject_records) !== $this->page){
            $this->http->redirect_subject(parent::get_next_stage($subject_records));
            return;
        }

		// HTTP GET Request
		if($this->http->is_get_request()){
			$this->process_get_request();
			return;
		}
		
		// HTTP POST Request
		$this->process_post_request();
	}
	
	/**
	 * Processes email registration and login authentication
	 * post requests.
	 * @param string $page 
	 */
	protected function process_post_request(){
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

		$this->set_entries();
        $this->set_errors();		

		// Form Error: redisplay form
		if($this->errors_found()){	
			$this->view->display($this->page, $this->get_form_fields($subject_records['id']));
			return;
        }	

        // Database Insert: answers to the final survey 
        foreach($this->form_fields as $key=>$answer){
            $this->db->set_answer($subject_records['id'], $key, $answer);
        }

        // Game Status Update: experiment completed
        $this->db->set_game_stage('completed', $subject_records['id']);

        // redirect to second set of survey questions 
		$this->http->redirect_subject("thankyou");
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
    protected function process_get_request(){
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());
        // Serve the Task form
		$this->view->display($this->page, $this->get_form_fields($subject_records['id']));
    }

    /**
     * Compiles and returns an array of parameters required for generating the Task form.
     *
     * @param array $subject_records
     * @return array form parameters
     */
    private function get_form_fields($subject_id){
        // get previous survey answers
        foreach($this->first_survey_answers as $key=>$answer){
            $this->first_survey_answers[$key] = $this->db->get_answer($subject_id, $key);
        }
        
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());
        $task['task'] = (empty($subject_records['first_task_completed']))?'not completed':'completed';
        return array_merge($task, $this->post_url, $this->form_fields, $this->form_errors, $this->first_survey_answers);
    }

	
	/**
	 * Places form entries into the form_fields instance array variables. 
	 */
	protected function set_entries(){
		// set form fields
		foreach($this->form_fields as $key=>$value){
			if(isset($_POST[$key])){
				$this->form_fields[$key] = trim($_POST[$key]);
				$this->form_fields[$key] = strip_tags($this->form_fields[$key]);
				$this->form_fields[$key] = htmlentities($this->form_fields[$key]);
			}
		}
	}
	
	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param subjectHTML $html
	 */
	protected function set_errors(){
    	$first_answers = array(
	        'question_20'=>'question_4_sub_1',
	        'question_21'=>'question_4_sub_2',
	        'question_22'=>'question_4_sub_3',
	        'question_23'=>'question_7_sub_1',
	        'question_24'=>'question_7_sub_2',
	        'question_25'=>'question_7_sub_3',
	        'question_26'=>'question_7_sub_4');
    	
		$validation_rules = array(
			'question_20'=>'contains_selection[same,more,less]',
			'question_21'=>'contains_selection[same,more,less]',
			'question_22'=>'contains_selection[same,more,less]',
			'question_23'=>'contains_selection[same,more,less]',
			'question_24'=>'contains_selection[same,more,less]',
			'question_25'=>'contains_selection[same,more,less]',
			'question_26'=>'contains_selection[same,more,less]',
	        'question_27'=>'is_number');
		
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());
        $this->form_errors = $this->validate->validate_entries($this->form_fields, $validation_rules);
        
        $first_survey_answers = array();
        foreach($this->first_survey_answers as $key=>$answer){
        	$first_survey_answers[$key] = $this->db->get_answer($subject_records['id'], $key);
        }
        
		for($i = 20; $i <= 26; ++$i){
			switch($this->form_fields['question_'.$i]){
				case 'same':
					if(!empty($this->form_fields['question_'.$i.'_sub_1']) && $this->form_fields['question_'.$i] !== $first_survey_answers[$first_answers['question_'.$i]]){
						$this->form_errors['error_question_'.$i.'_sub_1'] = "The hours entered must be equal to ".$first_survey_answers[$first_answers['question_'.$i]];
					}else{
						$this->form_errors['error_question_'.$i.'_sub_1'] = '';
					}
					break;
				case 'more':
					if(!is_numeric($this->form_fields['question_'.$i.'_sub_1'])){
						$this->form_errors['error_question_'.$i.'_sub_1'] = "The hours must be entered as a number".$first_survey_answers[$first_answers['question_'.$i]];
					}
					elseif($this->form_fields['question_'.$i.'_sub_1'] <= $first_survey_answers[$first_answers['question_'.$i]]){
						$this->form_errors['error_question_'.$i.'_sub_1'] = "The hours entered must be greater than ".$first_survey_answers[$first_answers['question_'.$i]];
					}else{
						$this->form_errors['error_question_'.$i.'_sub_1'] = '';
					}
					break;
				case 'less':
					if(!is_numeric($this->form_fields['question_'.$i.'_sub_1'])){
						$this->form_errors['error_question_'.$i.'_sub_1'] = "The hours must be entered as a number";
					}
					elseif($first_survey_answers[$first_answers['question_'.$i]] == 0){
						$this->form_errors['error_question_'.$i.'_sub_1'] = "Hours entered cannot be negative.";
					}
					elseif($this->form_fields['question_'.$i.'_sub_1'] >= $first_survey_answers[$first_answers['question_'.$i]]){
						$this->form_errors['error_question_'.$i.'_sub_1'] = "The hours entered must be less than ".$first_survey_answers[$first_answers['question_'.$i]];
					}else{
						$this->form_errors['error_question_'.$i.'_sub_1'] = '';
					}
					break;
				case '':
						$this->form_errors['error_question_'.$i.'_sub_1'] = '';
					break;					
			}
		}
		
		if(empty($this->form_fields['question_28'])){
			$this->form_errors['error_question_28'] = 'This field is requiried';
		}else{
			$this->form_errors['error_question_28'] = '';
		}
		
		$this->form_errors['error_question_29'] = '';
	}
	
	/**
	 * Returns true if an error is found
	 * in the form_errors array, otherwise 
	 * false is returned.
	 * @return boolean
	 */
	protected function errors_found(){
		foreach($this->form_errors as $key=>$value){
			if(!empty($value)){
				return true;
			}
		}
		
		return false;
	}
	
}
