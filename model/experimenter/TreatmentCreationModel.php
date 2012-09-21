<?php
class TreatmentCreationModel{
	
	private $date_keys = array(
	'first_experimenter_set_deadline'=>'datetime',
	'reminder_delivery_time'=>'time');
	
	/**
	 * Insert a subjects records into the database.
	 * @param array $subject_records
	 */
	public function add_subject(array $subject_records){
		$db = new Database();
		
		$formatted_records = $this->format_subject_entries_for_db_insertion($subject_records);
		return $db->insert("subject", $formatted_records);
	}
	
	/**
	 * Returns the next available treatment ID if one has
	 * already been created, otherwise treatment ID 1 is returned.
	 */
	public function get_next_available_treatment_id(){
		$db = new Database();
		$result = $db->select("subject", "ifnull(max(treatment_id)+1,1) as next_treatment_id");
		
		return $result[0]['next_treatment_id'];
	}
	
	/**
	 * Format the date/time elements in the records specified in
	 * date_keys array to time stamps.
	 * @param array $records
	 * @return array records 
	 */
	private function format_subject_entries_for_db_insertion(array $records){
		foreach($this->date_keys as $key=>$type){
			switch($type){
				case 'datetime':
					$records[$key] = date("Y-m-d H:i:s", strtotime($records[$key]));
					break;
				case 'time':
					$records[$key] = date("H:i:s", strtotime($records[$key]));
					break;
			}
				
		}
		
		return $records;
	}
}