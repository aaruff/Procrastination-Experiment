<?php
class ExperimenterLoginModel{
	
	/**
	 * Returns a specific experimenter record, specified by the
	 * $record parameter.
	 * @param string $record
	 * @param string $experimenter_id
	 * @return array experimenter record
	 */
	public function get_experimenter_record($record, $subject_id){
		$db = new Database();
		$where = sprintf("id='%s'", $db->escape_string($subject_id));
		
		$rows = $db->select("experimenter", $db->escape_string($record), $where);
		
		if(empty($rows)){
			return '';
		}
		
		return $rows[0][$record];
	}
	
	/**
	 * Returns experimenter records qualified by the participant ID.
	 * @param string $experimenter_id
	 * @return array experimenter records
	 */
	public function get_experimenter_records_1($experimenter_id){
		$db = new Database();
		$where = sprintf("id='%s'", $db->escape_string($participant_id));
		$rows = $db->select("experimenter", "*", $where);
		
		if(empty($rows)){
			return array();
		}
		
		return $rows[0];
	}
	
	/**
	 * Retruns experimenter records qualified by
	 * the login and password parameters.
	 * @param string $login
	 * @param string $password
	 * @return array experimenter records
	 */
	function get_experimenter_records_2($login, $password){
        $db = new Database();

		$login = $db->escape_string($login);
		$password = $db->escape_string($password);
		
		$where = sprintf("login='%s' and password='%s'", $login, $password);
		$rows = $db->select("experimenter", "*", $where);
		
		if(empty($rows)){
			return array();
		}

		
		return $rows[0];
	}
	
	function __call($name, $args) {
		$method = $name."_".count($args);
		if (!method_exists($this, $method)) {
			throw new Exception("Call to undefined method ".
			get_class($this)."::$method");
		}
		return call_user_func_array(array($this,$method),$args);
	}
}
