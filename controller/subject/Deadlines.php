<?php
class Deadlines extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
    private $validate;

    private $post_url;
	
	private $form_fields = array(
		'deadline_1'=>''
	);
	
	private $form_errors = array(
		'error_deadline_1'=>''
    );

    private $db_columns = array(
        'deadline_1'=>'first_subject_set_deadline');
	
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
	    // Subject not logged in	
        if(!$this->session->subject_session_active()){
            $this->http->redirect_subject('login');
        }

		// Subject Session Active, redirect to next stage
		if($this->session->subject_session_active()){	
			$subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());
			$next_page = parent::get_next_stage($subject_records);

			// Redirect to next stage if its not this one
			if($next_page !== $this->page){
				$this->http->redirect_subject($next_page);
				return;
			}
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
		$this->set_entries();
        $this->set_errors();		

        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());
		// form errors found: redisplay form
		if($this->errors_found()){	
	        $experimenter_deadline = date("m/d/Y h:i a", strtotime($subject_records['first_experimenter_set_deadline']));
			$form_values = array_merge($this->post_url, $this->form_fields, $this->form_errors, array('deadline'=>$experimenter_deadline));
			$this->view->display($this->page, $form_values);
			return;
        }	

        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        // insert survey entries into the database
        foreach($this->form_fields as $key=>$value){
            $this->db->set_deadline($subject_records['id'], $this->db_columns[$key], $value);
        }

        // set stage completion
        $this->db->set_registration_stage('deadline_set', $subject_records['id']);

        // Redirect: reminders enabled ask subject to pay for reminders
        if($subject_records['enable_reminder_notification'] === 'yes'){
            $this->http->redirect_subject("reminder");
            return;
        }

        // redirect to second set of survey questions 
		$this->http->redirect_subject("secondSurvey");
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
	protected function process_get_request(){
            $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        $experimenter_deadline = date("m/d/Y h:i a", strtotime($subject_records['first_experimenter_set_deadline']));
		$form_values = array_merge($this->post_url, $this->form_fields, $this->form_errors, array('deadline'=>$experimenter_deadline));
		$this->view->display($this->page, $form_values);
	}
	
	
	/**
	 * Places form entries into the form_fields instance array variables. 
	 */
	protected function set_entries(){
		// set form fields
		foreach($this->form_fields as $key=>$value){
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
		$validation_rules = array('deadline_1'=>'is_future_date_time');

        $this->form_errors = $this->validate->validate_entries($this->form_fields, $validation_rules);

        if(!$this->errors_found()){
            $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

            if(strtotime($this->form_fields['deadline_1']) > strtotime($subject_records['first_experimenter_set_deadline'])){
                $this->form_errors['error_deadline_1'] = "The deadline entered cannot exceed the experimenter set deadline of: ".date("m/d/Y h:i a", strtotime($subject_records['first_experimenter_set_deadline'])).".";
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
		foreach($this->form_errors as $key=>$value){
			if(!empty($value)){
				return true;
			}
		}
		
		return false;
	}
	
}
