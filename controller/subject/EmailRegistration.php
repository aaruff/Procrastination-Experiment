<?php 
class EmailRegistration extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
	private $validate;
	
	private $form_fields = array('post_url'=>'', 'email'=>'');
	
	private $form_errors = array('email_error'=>'');
	
	/**
	 * Initialize instance variables variables, and post_url.
	 * @param string $page
	 */
	public function __construct($page){
		$this->session = new SubjectSession();
		$this->http = new SubjectHTTP();
		$this->db = new EmailRegistrationModel();
		$this->view = new SubjectView();
		$this->page = $page;
		$this->validate = new Validate();
		
		$this->form_fields['post_url'] = WEB_ROOT.SUBJECT_DIR.$page;
	}
	
	/**
	 * Requests are redirected if the subject has an active session, and the
	 * next stage to visit is not this one. Otherwise the post or get page request
	 * is processed. 
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
		// form errors found: redisplay form
		if($this->errors_found()){	
			$form_values = array_merge($this->form_fields, $this->form_errors);
			$this->view->display($this->page, $form_values);
			return;
		}	

		//store email
		$result = $this->db->set_subject_email($this->form_fields['email'], $this->session->get_subject_session_id());

		// Email update failed
		if(empty($result)){
			// display an error	
		}
		
		// Update registration stage
		$result = $this->db->set_registration_stage('email_registered', $this->session->get_subject_session_id());
		$this->http->redirect_subject("firstSurvey");
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
	protected function process_get_request(){
		$form_values = array_merge($this->form_fields, $this->form_errors);
		$this->view->display($this->page, $form_values);
	}
	
	
	/**
	 * Places form entries into the form fields array. 
	 */
	protected function set_entries(){
		$this->form_fields['email'] = trim($_POST['email']);
	}
	
	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param subjectHTML $html
	 */
	protected function set_errors(){
		// invalid email
		if(!$this->validate->is_email($this->form_fields['email'])){
			$this->form_errors['email_error'] = "Invalid email";	
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
