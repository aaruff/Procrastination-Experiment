<?php
class SubjectModel{
	/**
	 * Returns a specific subject record, specified by the
	 * $record parameter.
	 * @param string $record
	 * @param string $subject_id
	 * @return array subject record
	 */
	public function get_subject_record($record, $subject_id){
        $db = new Database();

		$where = sprintf("id='%s'", $db->escape_string($subject_id));
		
		$rows = $db->select("subject", $record, $where);
		
		if(empty($rows)){
			return array();
		}
		
		return $rows[0][$record];
	}
	
	/**
	 * Returns subject records qualified by the participant ID.
	 * @param string $subject_id
	 * @return array subject records
	 */
	public function get_subject_records_1($subject_id){
        $db = new Database();

		$where = sprintf("id='%s'", $db->escape_string($subject_id));
		$rows = $db->select("subject", "*", $where);
		
		if(empty($rows)){
			return array();
		}
		
		return $rows[0];
    }

    /**
     * Set subject deadline date.
     * @param string subject_id
     * @param string column
     * @param deadline
     * @return integer
     */
    public function set_deadline($subject_id, $column, $deadline){
        $db = new Database();

        $set = sprintf("%s='%s'", $column, date("Y-m-d H:i:s", strtotime($deadline)));
        $where = sprintf("id='%s'", $db->escape_string($subject_id));

        return $db->update('subject', $set, $where);
    }
	
	/**
	 * Retruns subject records qualified by
	 * the login and password parameters.
	 * @param string $login
	 * @param string $password
	 * @return array subject records
	 */
	function get_subject_records_2($login, $password){
        $db = new Database();

		$where = sprintf("login='%s' and password='%s'", $db->escape_string($login), $db->escape_string($password));
		$rows = $db->select("subject", "*", $where);
		
		if(empty($rows)){
			return array();
		}

		return $rows[0];
	}

    /**
     * Used to fake function overloading for get_subject_recurds
     * @param string $name function name
     * @param array $args function arguments
     * @return mixed
     */    
	function __call($name, $args) {
		$method = $name."_".count($args);
		if (!method_exists($this, $method)) {
			throw new Exception("Call to undefined method ".
			get_class($this)."::$method");
		}
		return call_user_func_array(array($this,$method),$args);
    }

    /**
     * Updates the subjects survey status.
     * @param string $stage stage to update
     * @param string $subject_id 
     * @return integer
     */
    public function set_registration_stage($stage, $subject_id){
        $db = new Database();

		$stage = $db->escape_string($stage);
		$subject_id = $db->escape_string($subject_id);
		
		$set = sprintf("survey_status='%s'", $stage);
		
		$where = sprintf("id='%s'", $subject_id);
		
		return $db->update('subject', $set, $where);
    }

    /**
     * Updates the game survey status.
     * @param string $stage stage to update
     * @param string $subject_id 
     * @return integer
     */
    public function set_game_stage($stage, $subject_id){
        $db = new Database();

		$stage = $db->escape_string($stage);
		$subject_id = $db->escape_string($subject_id);
		
		$set = sprintf("game_status='%s'", $stage);
		
		$where = sprintf("id='%s'", $subject_id);
		
		return $db->update('subject', $set, $where);
    }

    /**
     * Updates the purchase reminder decision.
     * @param string $decision
     * @param string $subject_id 
     * @return integer
     */
    public function set_purchase_reminder($subject_id, $decision){
        $db = new Database();

		$purchase_decision = $db->escape_string($decision);
		$subject_id = $db->escape_string($subject_id);
		
		$set = sprintf("purchase_reminder='%s'", $purchase_decision);
		
		$where = sprintf("id='%s'", $subject_id);
		
		return $db->update('subject', $set, $where);
	}

}
