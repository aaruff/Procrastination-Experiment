<?php 
class ViewSubjects{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
	
	/**
	 * Initialize instance variables variables, and post_url.
	 * @param string $page
	 */
	public function __construct($page){
		$this->session = new ExperimenterSession();
		$this->http = new ExperimenterHTTP();
		$this->db = new ViewSubjectsModel();
		$this->view = new ExperimenterView();
		$this->page = $page;
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
	 */
	private function process_post_request(){
		$subjects = $this->db->get_subjects();
		$this->view->display($this->page, $subjects);
	}	
	
	/**
	 * Process get requests for the email registration authentication page.
	 */
	private function process_get_request(){
		$subjects = $this->db->get_subjects();
		$this->view->display($this->page, $subjects);
	}
	
	
	
	
}
