<?php
class FileOutputModel{
	
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

    private function get_where_string_from_treatments($db, $treatments){
        // construct where string
        if($treatments['type'] === 'list'){
            foreach($treatments['values'] as $value){
                $where[] = sprintf("treatment_id='%s'", $db->escape_string($value));
            }

            return implode(" OR ", $where);
        }
        
        if($treatments['type'] === 'range'){
	        return sprintf("treatment_id >= '%s' and treatment_id <= '%s'", $treatments['values'][0], $treatments['values'][1]);
        }
        
        return sprintf("treatment_id = %s", $treatments['values'][0]);
    }

    public function get_subjects_in_treatments(array $treatments){
        $db = new Database();
        
        $where = $this->get_where_string_from_treatments($db, $treatments);
        $rows = $db->select('subject', '*', $where);

        if(empty($rows)){
            return array();
        }

        return $rows;
    }

    public function get_task_logs_by_subjects(array $subjects){
        $db = new Database();

        foreach($subjects as $subject){
            $where[]  = sprintf("subject_id = '%s'", $subject['id']);
        }
        
        $rows = $db->select('task_log', "*", implode(" OR ", $where));

        if(empty($rows)){
            return array();
        }

        return $rows;
    }


    public function get_survey_answers_by_subjects(array $subjects){
        $db = new Database();

        foreach($subjects as $subject){
            $where[]  = sprintf("subject_id = '%s'", $subject['id']);
        }
        
        $rows = $db->select('survey_answer', "*", implode(" OR ", $where));

        if(empty($rows)){
            return array();
        }

        return $rows;
    }
	
}
