<?php
class TaskModel extends SubjectModel{

    /**
     * Sets survey question answers.
     *
     * @param string $subject_id
     * @param string $question_key
     * @param string $answer
     * @return integer
     */
	public function set_answer($subject_id, $question_key, $answer){
        $db = new Database();

        // set escaped set values    
        $set['question_key'] = $db->escape_string($question_key);
        $set['answer'] = $db->escape_string($answer);
        $set['subject_id'] = $db->escape_string($subject_id);
		
		return $db->insert('survey_answer', $set);
    }

    /**
     * Sets the task log for $subject_id.
     *
     * @param string $subject_id
     * @param string $date_time timestamp
     * @param string $event
     * @param string $task 
     * @return integer number of rows effected.
     */
    public function set_task_log($subject_id, $date_time, $event, $task){
        $db = new Database();

        $set['subject_id'] = $db->escape_string($subject_id);
        $set['date_time'] = date("Y-m-d H:i:s", $date_time);
        $set['event'] = $db->escape_string($event);
        $set['task'] = $db->escape_string($task);

        return $db->insert('task_log', $set);
    }

    public function set_task_completed($subject_id, $task, $datetime){
        $db = new Database(); 

        $set = sprintf("%s_completed='%s'", $task, date("Y-m-d H:i:s", $datetime));
        $where = sprintf("id='%s'", $db->escape_string($subject_id));

        return $db->update('subject', $set, $where);
    }

    /**
     * Returns a timestamp of the last time a problem was issued to
     * $subject_id.
     *
     * @param string $subject_id
     * @return timestamp
     */
    public function get_time_last_problem_issued($subject_id){
        $db = new Database();

        $where = sprintf("event='new_problem' and subject_id='%s'", $db->escape_string($subject_id));
        $select = 'max(date_time) as date_time';

        $rows= $db->select("task_log", $select, $where);

        if(empty($rows)){
            return array();
        }

        return strtotime($rows[0]['date_time']);
    }
}
