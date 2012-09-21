<?php
abstract class FormController{

	abstract public function process_page_request();
	abstract protected function process_get_request();
	abstract protected function process_post_request();
	abstract protected function set_entries();
	abstract protected function set_errors();
	abstract protected function errors_found();
	
	public function get_next_stage(array $subject){
		if(!isset($subject['survey_status']) || !isset($subject['game_status'])){
			return 'login';
		}
		
		// game not started, still registering
		if($subject['game_status'] === 'not_started'){
			switch($subject['survey_status']){
				case 'unregistered':
					return 'registerEmail';
					break;
				case 'email_registered':
					return 'firstSurvey';
					break;
                case 'first_completed':
                    // subject deadline follows first survey if required  
                    if($subject['subject_deadline_enabled'] === 'yes'){
                        return 'setDeadlines';
                    }

                    // reminder payment follows first survey if requred 
                    if($subject['enable_reminder_notification'] === 'yes'){
                        return 'reminder';
                    }

                    return 'secondSurvey';
					break;
                case 'deadline_set':
                    // reminder payment follows the deadline if set
                    if($subject['enable_reminder_notification'] === 'yes'){
                        return 'reminder';
                    }

                    return 'secondSurvey';
                    break;
                case 'reminder_payment_completed':
                    return 'secondSurvey';
                    break;
                case 'second_completed':
                    return 'surveyConclusion';
					break;
                case 'survey_completed':
					break;
			}
		}
		
		// game started
		switch($subject['game_status']){
            case 'first_task':
                return 'task';
				break;
            case 'outgoing_survey':
                return 'finalSurvey';
                break;
            case 'completed':
                return 'thankyou';
				break;
        }

        return 'login';
	}
}
