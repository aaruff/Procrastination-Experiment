<?php
class Reminder extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
    private $validate;

    private $post_url;
	
	private $form_fields = array(
		'purchase_reminder'=>''
	);
	
	private $form_errors = array(
		'error_purchase_reminder'=>''
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
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

		$this->set_entries();
        $this->set_errors();		

		// form errors found: redisplay form
        if($this->errors_found()){	
            $reminder_cost = array('reminder_cost'=>$subject_records['reminder_cost']);
            $reminder_time = array('reminder_time'=>date("h:i a", strtotime($subject_records['reminder_delivery_time'])));
			$form_values = array_merge($this->post_url, $this->form_fields, $this->form_errors, $reminder_cost, $reminder_time);
			$this->view->display($this->page, $form_values);
			return;
        }	

        // Database Update: set subject reminder payment decision 
        $this->db->set_purchase_reminder($subject_records['id'], $this->form_fields['purchase_reminder']);

        // Database Update: set stage completion
        $this->db->set_registration_stage('reminder_payment_completed', $subject_records['id']);

        // redirect to second set of survey questions 
		$this->http->redirect_subject("secondSurvey");
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
	protected function process_get_request(){
        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        $reminder_cost = array('reminder_cost'=>$subject_records['reminder_cost']);
        $reminder_time = array('reminder_time'=>date("h:i a", strtotime($subject_records['reminder_delivery_time'])));

		$form_values = array_merge($this->post_url, $this->form_fields, $this->form_errors, $reminder_cost, $reminder_time);
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
		$validation_rules = array(
		'purchase_reminder'=>'contains_selection[yes,no]'
        );

        $this->form_errors = $this->validate->validate_entries($this->form_fields, $validation_rules);
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
