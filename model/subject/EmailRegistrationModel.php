<?php
class EmailRegistrationModel extends SubjectModel{

	public function set_subject_email($email, $subject_id){
        $db = new Database();

		// escape user entries
		$email = $db->escape_string($email);
		$subject_id = $db->escape_string($subject_id);
		
		$set = sprintf("email='%s'", $email);
		$where = sprintf("id='%s'", $subject_id);
		
		return $db->update('subject', $set, $where);
	}
	
	public function set_registration_stage($stage, $subject_id){
        $db = new Database();

		$stage = $db->escape_string($stage);
		$subject_id = $db->escape_string($subject_id);
		
		$set = sprintf("survey_status='%s'", $stage);
		
		$where = sprintf("id='%s'", $subject_id);
		
		return $db->update('subject', $set, $where);
	}
}
