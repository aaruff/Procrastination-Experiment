<?php 
class OutputFile{
	private $page;
	private $session;
	private $http;
	private $db;
    private $view;

    private $form_errors = array('error_treatment_selection'=>'');
    private $form_values = array('treatment_selection'=>'');
    private $post_url;
	/**
	 * Initialize instance variables variables, and post_url.
	 * @param string $page
	 */
	public function __construct($page){
		$this->session = new ExperimenterSession();
		$this->http = new ExperimenterHTTP();
		$this->db = new FileOutputModel();
        $this->view = new ExperimenterView();
        $this->page = $page;
		$this->post_url = array('post_url'=>WEB_ROOT.EXPERIMENTER_DIR.$page);
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
        $this->set_form_entries();
        $this->set_errors();

        if($this->errors_found()){
            $this->view->display($this->page, array_merge($this->post_url, $this->form_errors, $this->form_values));
            return;
        }

        // get form entries
        $treatments = $this->get_treatment_selection();

        $subjects = $this->db->get_subjects_in_treatments($treatments);
        $survey_answers = $this->db->get_survey_answers_by_subjects($subjects);
        $logs = $this->db->get_task_logs_by_subjects($subjects);

        $file_location = array('file_location'=>$this->write_csv_file($subjects, $logs, $survey_answers));

        $this->view->display($this->page, array_merge($this->post_url, $file_location, $this->form_errors, $this->form_values));
    }	
    
    private function write_csv_file(array $subjects,array $logs, array $survey_answers){
        $xls_file_path = './output/';

        $subjects_header = array(
            array('Subject ID', 'Login', 'Password', 'Email',
            'Treatment ID', 'Survey Status', 'Subject Deadline Enabled',
            'Experimenter Set Deadline: Task 1', 'Subject Set Deadline: Task 1',
            'Problem Time Limit', 'Reminder Notification Enabled', 'Reminder Notification Delivery Time',
            'Reminder Notification Cost', 'Reminder Notification Purchased', 'Game Status', 'Time Task 1 Completed'));

        $task_log_header = array(array('Task Log ID', 'Subject ID', 'Date and Time', 'Event', 'Task'));

        $survey_answer_header = array(array('ID', 'Subject ID', 'Question Key', 'Answer'));
        
        $subject_data = array_merge($subjects_header, $subjects);
        $survey_data = array_merge($survey_answer_header, $survey_answers);
        $task_log_data = array_merge($task_log_header, $logs);

        $session_id = $this->session->get_experimenter_session_id();
        $file_name =substr(md5($session_id),0,3).'-output.xls';
        $fp = fopen($xls_file_path . $file_name, "w");
        

        foreach($subject_data as $row){
            fputcsv($fp, $row);
        }

        foreach($task_log_data as $row){
            fputcsv($fp, $row);
        }

        foreach($survey_data as $row){
            fputcsv($fp, $row);
        }

        fclose($fp);

        return $xls_file_path . $file_name;
    }

    /**
     * Retrieves from entries from the POST array
     */
    private function set_form_entries(){
        foreach($this->form_values as $key=>$value){
            if(isset($_POST[$key])){
                $this->form_values[$key] = htmlspecialchars(trim($_POST[$key]));
            } 
        }
    }

    private function errors_found(){
        foreach($this->form_errors as $error){
            if(!empty($error)){
                return true;
            }
        }

        return false;
    }

    private function error_found(){
        if(!empty($this->form_errors['treatment_selection'])){
            return true;
        }

        return false;
    }

    private function set_errors(){
        if(!$this->validate_form_entries()){
            $this->form_errors['error_treatment_selection'] = 'error found, please check your syntax';
        }
    }

    /**
     * Returns an a array of treatment ranges or list in the following
     * form:
     * array(
     *  'type'=>'list|type',
     *  'values'=>array()
     *  )
     *
     *  @return array
     */
    private function get_treatment_selection(){
        // No selection made
        $treatment_selection = $this->form_values['treatment_selection'];

        // Treatment List: (E.g. 1, 4, 8)
        if(preg_match("/^(\d+,\s*)+\d+$/D", $treatment_selection)){
            $exploded_selection = explode(",", $treatment_selection);

            $selection['type'] = 'list';

            foreach($exploded_selection as $key=>$value){
               $entries[] = trim($value);
            }

            $selection['values'] = $entries;
            return $selection;
        }

        // Treatment List: (E.g. 1-4)
        if(preg_match("/^\d+\s*-\s*\d+$/D", $treatment_selection)){
	        $selection['type'] = 'range';
	
	        $exploded_selection = explode("-", $treatment_selection);
	        foreach($exploded_selection as $value){
	           $entries[] = trim($value);
	        }
	
	        $selection['values'] = $entries;
	        return $selection;
        }
        
        if(preg_match('/^\d+$/D', $treatment_selection)){
        	$selection['values'] = array($treatment_selection);
	        $selection['type'] = 'individual';
        }

        return $selection;
    }

    private function validate_form_entries(){
        // No selection made
        $treatment_selection = $this->form_values['treatment_selection'];
        if(empty($treatment_selection)){
            return false; 
        }

        // list found
        if(preg_match("/^(\d+,\s*)+\d$/D", $treatment_selection)){
            return true; 
        }

        // range found 
        if(preg_match("/^\d+\s*-\s*\d+$/D", $treatment_selection)){
            return true;
        }
        
        if(preg_match('/^\d+$/D', $treatment_selection)){
        	return true;
        }
        
        // neither found
        return false;
    }
	
	/**
	 * Process get requests for the email registration authentication page.
	 */
    private function process_get_request(){
		$this->view->display($this->page, array_merge($this->post_url, $this->form_errors, $this->form_values));
	}
	
}
