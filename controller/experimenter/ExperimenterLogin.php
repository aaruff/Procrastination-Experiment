<?php
class ExperimenterLogin{
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
		$this->session = new ExperimenterSession();
		$this->http = new ExperimenterHTTP();
		$this->db = new ExperimenterLoginModel();
		$this->view = new ExperimenterView();
		$this->page = $page;

		$this->form_fields['post_url'] = WEB_ROOT.EXPERIMENTER_DIR.$page;
	}

    /**
	 * Processes email registration and login authentication
	 * post requests.
	 * @param string $page
	 */
    private function process_post_request(){
		$this->set_entries();
		$this->set_errors();
		// form entries or authentication invalid: redisplay form
        if(!$this->validate_entries()){
			$form_values = array_merge($this->form_fields, $this->form_errors);
			$this->view->display($this->page, $form_values);
			return;
		}

		$experimenter_records = $this->db->get_experimenter_records($_POST['login'], $_POST['password']);
        $this->session->save('experimenter_id', $experimenter_records['id']);
		$this->http->redirect_experimenter("viewSubjects");
	}

    /**
     * Processes email and registration login page requests.
     */
    public function process_page_request(){

        // Experimenter Session Active
        if($this->session->experimenter_session_active()){
            $this->http->redirect_experimenter('viewSubjects');
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
	 * Process get requests for the email registration authentication page.
	 * @param unknown_type $page
	 */
	private function process_get_request(){
		$form_values = array_merge($this->form_fields, $this->form_errors);
		$this->view->display($this->page, $form_values);
	}
	
	private function set_entries(){
		$this->form_fields['login'] = $_POST['login'];
		$this->form_fields['password'] = $_POST['password'];
	}
	
	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param experimenterHTML $html
	 */
	private function set_errors(){
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
		
	private function registration_complete($experimenter_id){
		$next_form = $this->db->get_next_registration_page($experimenter_id);

		if(empty($next_form)){
			return false;
		}
		
		return true;
	}

	
	/**
	 * Returns true if all the entries are completed and correctly
	 * formatted, otherwise false is returned.
	 * @return boolean
	 */
	private function validate_entries(){
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
	 * Returns true if the experimenters login and password
	 * have been authenticated.
	 * @param string login
	 * @param string password
	 * @return boolean
	 */
	private function authenticate_credentials(){
		$model = new ExperimenterLoginModel();
		$experimenter_records = $model->get_experimenter_records($_POST['login'], $_POST['password']);
		
		if(empty($experimenter_records)){
			return false;
		}
		
		return true;
	}
	
	
}
