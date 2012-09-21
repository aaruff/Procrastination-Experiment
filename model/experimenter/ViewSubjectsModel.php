<?php
class ViewSubjectsModel{
	
	/**
	 * Returns all subject records
	 */
	public function get_subjects(){
		$db = new Database();
		$result = $db->select("subject", "*");
		return array('subjects'=>$result);
    }

	/**
	 * Returns all subject records
	 */
	public function get_task_logs(){
		$db = new Database();
		$result = $db->select("task_log", "*");
		return array('subjects'=>$result);
	}
	
}
