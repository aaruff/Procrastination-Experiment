<?php
class SubjectLogin extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
	
	private $form_fields = array(
		'post_url'=>'',
		'login'=>'',
		'password'=>'');
	
	private $form_errors = array(
		'general_error'=>'',
		'login_error'=>'',
		'password_error'=>'',
	);
	
	/**
	 * Initialize instance variables variables, and post_url.
	 * @param string $page
	 */
	public function __construct($page){
		$this->session = new SubjectSession();
		$this->http = new SubjectHTTP();
		$this->db = new SubjectModel();
		$this->view = new SubjectView();
		$this->page = $page;
		
		$this->form_fields['post_url'] = WEB_ROOT.SUBJECT_DIR.$page;
	}
	
	/**
	 * Processes email and registration login page requests.
	 */
	public function process_page_request(){		

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
	protected function process_post_request(){
		$this->set_entries();
		$this->set_errors();	
			
		// form entries or authentication invalid: redisplay form
		if(!$this->errors_found()){	
			$form_values = array_merge($this->form_fields, $this->form_errors);
			$this->view->display($this->page, $form_values);
			return;
		}	
		
		$subject_records = $this->db->get_subject_records($this->form_fields['login'], $this->form_fields['password']);	
		$this->session->save('subject_id', $subject_records['id']);
		
		$next_stage = parent::get_next_stage($subject_records);
		$this->http->redirect_subject($next_stage);
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
    protected function process_get_request(){		// Subject Session Active
       $this->session->unset_subject_session();
       
		$form_values = array_merge($this->form_fields, $this->form_errors);
		$this->view->display($this->page, $form_values);
	}
	
	protected function set_entries(){
		$this->form_fields['login'] = trim($_POST['login']);
		$this->form_fields['password'] = trim($_POST['password']);
	}
	
	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param subjectHTML $html
	 */
	protected function set_errors(){
		// invalid login
		if($_POST['login'] == '' || !isset($_POST['login'])){
			$this->form_errors['login_error'] = "Login name required";	
		}
		
		// invalid password
		if($_POST['password'] == '' || !isset($_POST['password'])){
			$this->form_errors['password_error'] = "Password required";
		}	
		
		// invalid login credentials
		if(!$this->authenticate_credentials()){
			$this->form_errors['general_error'] = "Invalid login credentials. Check your login and password.";
		}	
	}		

	/**
	 * Returns true if all the entries are completed and correctly
	 * formatted, otherwise false is returned.
	 * @return boolean
	 */
	protected function errors_found(){
		$login_entered = !empty($_POST['login']);
		$password_entered = !empty($_POST['password']);
		
		$entries_valid = $login_entered && $password_entered;
		
		if(!$entries_valid){
			return false;
		}
		
		// invalid login credentials
		if(!$this->authenticate_credentials()){
			return false;
		}
		
		// entry and credentals are valid
		return true;
	}
	
	/**
	 * Returns true if the subject login and password
	 * have been authenticated.
	 * @param string login
	 * @param string password
	 * @return boolean
	 */
	protected function authenticate_credentials(){
		$subject_records = $this->db->get_subject_records($this->form_fields['login'], $this->form_fields['password']);
		
		if(empty($subject_records)){
			return false;
		}
		
		return true;
	}
	
	
}
