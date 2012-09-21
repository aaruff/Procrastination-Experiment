<?php
class FirstSurvey extends FormController{
	private $page;
	private $session;
	private $http;
	private $db;
	private $view;
    private $validate;

    private $post_url;
	
	private $form_fields = array(
		'question_1'=>'',
		'question_2'=>'',
		'question_3'=>'',
		'question_4_sub_1'=>'',
		'question_4_sub_1_date_1'=>'',
		'question_4_sub_2'=>'',
		'question_4_sub_2_date_1'=>'',
        'question_4_sub_3'=>'',
		'question_4_sub_3_date_1'=>'',
        'question_5'=>'',
		'question_6'=>'',
		'question_7'=>'',
		'question_7_sub_1'=>'',
		'question_7_sub_2'=>'',
		'question_7_sub_2_start_date_1'=>'',
		'question_7_sub_2_end_date_1'=>'',
		'question_7_sub_3'=>'',
		'question_7_sub_3_start_date_1'=>'',
		'question_7_sub_3_end_date_1'=>'',
		'question_7_sub_4'=>'',
		'question_7_sub_4_start_date_1'=>'',
		'question_7_sub_4_end_date_1'=>'',
		'question_8_sub_1'=>'',
		'question_8_sub_2'=>'',
		'question_8_sub_3'=>'',
		'question_9_sub_1'=>'',
		'question_9_sub_2'=>'',
		'question_9_sub_3'=>'',
		'question_9_sub_4'=>'',
		'question_9_sub_5'=>'',
		'question_10'=>'',
		'question_11'=>'',
		'question_12'=>'',
		'question_13'=>''
	);
	
	private $form_errors = array(
		'error_question_1'=>'',
		'error_question_2'=>'',
		'error_question_3'=>'',
		'error_question_4_sub_1'=>'',
		'error_question_4_sub_1_date_1'=>'',
		'error_question_4_sub_2'=>'',
		'error_question_4_sub_2_date_1'=>'',
        'error_question_4_sub_3'=>'',
		'error_question_4_sub_3_date_1'=>'',
        'error_question_5'=>'',
		'error_question_6'=>'',
		'error_question_7_sub_1'=>'',
		'error_question_7_sub_2'=>'',
		'error_question_7_sub_3'=>'',
		'error_question_7_sub_4'=>'',
		'error_question_8_sub_1'=>'',
		'error_question_8_sub_2'=>'',
		'error_question_8_sub_3'=>'',
		'error_question_9_sub_1'=>'',
		'error_question_9_sub_2'=>'',
		'error_question_9_sub_3'=>'',
		'error_question_9_sub_4'=>'',
		'error_question_9_sub_5'=>'',
		'error_question_10'=>'',
		'error_question_11'=>'',
		'error_question_12'=>'',
		'error_question_13'=>'',
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
        $this->set_entries();
        $this->set_errors();		
        
		// form errors found: redisplay form
		if($this->errors_found()){	
			$form_values = array_merge($this->post_url, $this->form_fields, $this->form_errors);
			$this->view->display($this->page, $form_values);
			return;
        }	

        $subject_records = $this->db->get_subject_records($this->session->get_subject_session_id());

        // insert survey entries into the database
        foreach($this->form_fields as $key=>$answer){
            $this->db->set_answer($subject_records['id'], $key, $answer);
        }

        // set stage completion
        $this->db->set_registration_stage('first_completed', $subject_records['id']);

        // redirect to deadline page if the treatment requires it
        if($subject_records['subject_deadline_enabled'] === 'yes'){
            $this->http->redirect_subject("setDeadlines");
            return;
        }

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
        $this->set_entries();
		$form_values = array_merge($this->post_url, $this->form_fields, $this->form_errors);
		$this->view->display($this->page, $form_values);
    }

	/**
	 * Places form entries into the form_fields instance array variables. 
	 */
	protected function set_entries(){
		// set form fields
		foreach($this->form_fields as $key=>$value){
			if(isset($_POST[$key])){
				$this->form_fields[$key] = trim($_POST[$key]);
			}
			
			$question_four = array('question_4_sub_1', 'question_4_sub_2', 'question_4_sub_3');
			foreach($_POST as $key=>$val){
				if(preg_match('/^question_4_sub_[1-3]_date_([0-9]|1[0-9]|20)$/', $key)){
					$this->form_fields[$key] = $val;
					$this->form_errors['error_'.$key] = '';
				}
				//'question_7_sub_2_start_date_1
				elseif(preg_match('/^question_7_sub_[2-4]_start_date_([0-9]|1[0-9]|20)$/', $key)){
					$this->form_fields[$key] = $val;
					$this->form_errors['error_'.$key] = '';
				}
				elseif(preg_match('/^question_7_sub_[2-4]_end_date_([0-9]|1[0-9]|20)$/', $key)){
					$this->form_fields[$key] = $val;
					$this->form_errors['error_'.$key] = '';
				}
			}
		
	    }

        $date_questions = array(
            4=>array(1,2,3),
            7=>array(1,2,3,4)
        );

        // Set validation for all dynamic date and time fields
        foreach($date_questions as $parent_question=>$sub_questions){
            foreach($sub_questions as $sub_question){
                for($i = 2; $i <= 20; ++$i){
                    //QUESTION 4: Date only
                    if($parent_question == 4){
                        $date_id = sprintf('question_%s_sub_%s_date_%s', $parent_question, $sub_question, $i);
                        
                        // Exit loop: no more dates remain for this question
                        if(!isset($_POST[$date_id])){
                            break;
                        }

                        $this->form_fields[$date_id] = $_POST[$date_id];
                    }
                    else{ // QUESTION 7: Date and time
                        $start_date_id = sprintf('question_%s_sub_%s_start_date_%s', $parent_question, $sub_question, $i);
                        $end_date_id = sprintf('question_%s_sub_%s_end_date_%s', $parent_question, $sub_question, $i);

                        if(!isset($_POST[$start_date_id]) && !isset($_POST[$end_date_id])){
                            break;
                        }

                        if(isset($_POST[$start_date_id])){
                            $this->form_fields[$start_date_id] = $_POST[$start_date_id];
                        }

                        if(isset($_POST[$end_date_id])){
                            $this->form_fields[$end_date_id] = $_POST[$end_date_id];
                        }
                    }
                }
            }
        }
    }

	/**
	 * Sets the registration error fields with
	 * the corresponding entry errors.
	 * @param subjectHTML $html
	 */
	protected function set_errors(){
		$question_four = array('question_4_sub_1', 'question_4_sub_2', 'question_4_sub_3');
		$question_seven = array('question_7_sub_2', 'question_7_sub_3', 'question_7_sub_4');
		
		$validation_rules = array(
		'question_1'=>'is_integer',
		'question_2'=>'is_alpha',
		'question_3'=>'is_number',
		'question_4_sub_1'=>'is_integer',
		'question_4_sub_2'=>'is_integer',
        'question_4_sub_3'=>'is_integer',
		'question_5'=>'contains_selection[unemployed,paid,unpaid]',
		'question_6'=>'is_integer',
		'question_7_sub_1'=>'is_integer',
		'question_7_sub_2'=>'is_integer',
		'question_7_sub_3'=>'is_integer',
		'question_7_sub_4'=>'is_integer',
		'question_8_sub_1'=>'is_integer[1,5]',
		'question_8_sub_2'=>'is_integer[1,5]',
		'question_8_sub_3'=>'is_integer[1,5]',
		'question_9_sub_1'=>'is_integer[1,5]',
		'question_9_sub_2'=>'is_integer[1,5]',
		'question_9_sub_3'=>'is_integer[1,5]',
		'question_9_sub_4'=>'is_integer[1,5]',
		'question_9_sub_5'=>'is_integer[1,5]',
		'question_10'=>'is_integer',
		'question_11'=>'is_integer[1,3]',
		'question_12'=>'is_integer',
        'question_13'=>'is_integer');

        $date_questions = array(
            4=>array(1,2,3),
            7=>array(2,3,4)
        );
        

        // Set validation for question 7 dynamic date and time fields
        foreach($date_questions as $parent_question=>$sub_questions){
            foreach($sub_questions as $sub_question){
                for($i = 1; $i <= 20; ++$i){

                    // Question 4
                    if($parent_question == 4){
                        $date_id = sprintf('question_4_sub_%s_date_%s', $sub_question, $i);
						$parent_question_key = sprintf('question_4_sub_%s', $sub_question);
						
                        if(isset($this->form_fields[$date_id]) && !empty($this->form_fields[$date_id]) && $this->form_fields[$parent_question_key] != 0){
                            $validation_rules[$date_id] = 'is_future_date';
                        }
                    }
                    else{// Question 7
                        $date_id = sprintf('question_7_sub_%s_date_%s', $sub_question, $i);
						$parent_question_key = sprintf('question_7_sub_%s', $sub_question);
						
                        if($sub_question == 2 && isset($this->form_fields['question_5']) && $this->form_fields['question_5'] === 'unemployed'){
                            break;
                        }
                        
                        $start_date_id = sprintf('question_%s_sub_%s_start_date_%s', $parent_question, $sub_question, $i);
                        $end_date_id = sprintf('question_%s_sub_%s_end_date_%s', $parent_question, $sub_question, $i);

                        if(isset($this->form_fields[$start_date_id]) && !empty($this->form_fields[$start_date_id]) && $this->form_fields[$parent_question_key] != 0){
                            $validation_rules[$start_date_id] = 'is_future_date_time';
                        }

                        if(isset($this->form_fields[$end_date_id]) && !empty($this->form_fields[$end_date_id]) && $this->form_fields[$parent_question_key] != 0){
                            $validation_rules[$end_date_id] = 'is_future_date_time';
                        }
                    }
                }
            }
        }

        $errors = $this->validate->validate_entries($this->form_fields, $validation_rules);
        $this->form_errors = array_merge($this->form_errors, $errors);
        
        if($this->form_fields['question_3'] > 4 || $this->form_fields['question_3'] < 0){
        	$this->form_errors['error_question_3'] = 'Invalid GPA entered.';
        }

        foreach($question_four as $key){
	       	if(empty($this->form_errors['error_'.$key])){
	       		// make sure the number of dates match the task count
	        	$task_count = $this->form_fields[$key];
	        	$temp_count = 0;
	        	
	        	// Matches number of occuraces to dates entered
	        	for($i = 1; $i < $task_count+1; ++$i){
	        		if(key_exists($key.'_date_'.$i, $this->form_fields)){
	        			if(!empty($this->form_fields[$key.'_date_'.$i])){
		        			++$temp_count;
	        			}
	        			
	        			//$this->form_errors['error_'.$key.'_date_'.$i] = (empty($this->form_errors['error_'.$key.'_date_'.$i]))?'':$this->form_errors['error_'.$key.'_date_'.$i];
	        		}
	        	}
	        	
	        	if($temp_count != $task_count && $this->form_fields[$key] != 0){
	        		$this->form_errors['error_'.$key] = 'The number of occurances must match the dates entered.';
	        	}
	        	
	        	// matches dates to number of occurances
	        	$date_counter =  0;
	        	// find dates
	        	foreach($this->form_fields as $form_key=>$value){
	        		//'question_7_sub_2_start_date_1
	        		if(preg_match('/^'.$key.'_date_([0-9]|1[0-9]|20)$/', $form_key) > 0){
	        			if(!empty($this->form_fields[$form_key])){
		        			++$date_counter;
	        			}
	        		}
	        	}
	        	
	        	if($date_counter != $task_count){
        			$this->form_errors['error_'.$key] = 'The number of dates must match the number of occurances entered.';
	        	}
	       	}
        }
        //question_7_sub_2_start_date_1
        foreach($question_seven as $key){
        	if(empty($this->form_errors['error_'.$key])){
	        	$task_count = $this->form_fields[$key];
	        	$start_count = $end_count = 0;
	        	
	        	// Matches number of occurances to dates entered
	        	for($i = 1; $i < $task_count+1; ++$i){
	        		if(key_exists($key.'_start_date_'.$i, $this->form_fields)){
	        			if(!empty($this->form_fields[$key.'_start_date_'.$i])){
		        			++$start_count;
	        			}
	        			//$this->form_errors['error_'.$key.'_start_date_'.$i] = '';
	        		}
	        		if(key_exists($key.'_end_date_'.$i, $this->form_fields)){
	        			if(!empty($this->form_fields[$key.'_end_date_'.$i])){
		        			++$end_count;
	        			}
	        			//$this->form_errors['error_'.$key.'_end_date_'.$i] = '';
	        		}
	        		
	        		if(empty($this->form_errors['error_'.$key.'_start_date_'.$i]) && empty($this->form_errors['error_'.$key.'_end_date_'.$i])){
	        			if(!empty($this->form_fields[$key.'_start_date_'.$i]) && !empty($this->form_fields[$key.'_end_date_'.$i])){
		        			$start_date_time = new DateTime($this->form_fields[$key.'_start_date_'.$i]);
		        			$end_date_time = new DateTime($this->form_fields[$key.'_end_date_'.$i]);
		        			if($start_date_time >= $end_date_time){
			        			$this->form_errors['error_'.$key.'_end_date_'.$i] = 'Invalid date order.';
		        			}
	        			}
	        		}
	        	}
	        	
	        	if($task_count > 0 && $end_count == 0 && $start_count == 0){
	        		if($key != 'question_7_sub_2' || $this->form_fields['question_5'] != 'unemployed'){
		        		$this->form_errors['error_'.$key] = 'At least one start/end date and time is required.';
	        		}
	        	}

	        	// matches dates to number of occurances
	        	$start_date_counter = $end_date_counter = 0;
	        	// find dates
	        	foreach($this->form_fields as $form_key=>$value){
					//'question_7_sub_2_start_date_1
					if(preg_match('/^'.$key.'_start_date_([0-9]|1[0-9]|20)$/', $form_key) > 0){
						if(!empty($this->form_fields[$form_key])){
							++$start_date_counter;	
						}
					}
					if(preg_match('/^'.$key.'_end_date_([0-9]|1[0-9]|20)$/', $form_key) > 0){
						++$end_date_counter;
					}
	        	}
	        	
	        	if($start_date_counter != $start_count || $end_date_counter != $end_count){
	        		if(($key != 'question_7_sub_2' || $this->form_fields['question_5'] != 'unemployed') && $this->form_fields[$key] != 0){
		        		$this->form_errors['error_'.$key] = 'The number of dates must match the number entered.';
	        		}
	        	}
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
