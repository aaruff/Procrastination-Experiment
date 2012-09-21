<?php
class ThankYou extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
    private $validate;

    private $post_url;
	
	private $form_fields = array(
    );

	private $form_errors = array(
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
		$this->view->display($this->page);
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
    protected function process_get_request(){
		$this->view->display($this->page);
    }

    /**
     * Compiles and returns an array of parameters required for generating the Task form.
     *
     * @param array $subject_records
     * @return array form parameters
     */
    private function get_form_fields($subject_id){
    }

	
	/**
	 * Places form entries into the form_fields instance array variables. 
	 */
	protected function set_entries(){
	}
	
	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param subjectHTML $html
	 */
	protected function set_errors(){
	}
	
	/**
	 * Returns true if an error is found
	 * in the form_errors array, otherwise 
	 * false is returned.
	 * @return boolean
	 */
	protected function errors_found(){
	}
	
}
