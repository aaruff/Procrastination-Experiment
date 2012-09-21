<?php
class SurveyModel extends SubjectModel{

    /**
     * Sets survey question answers.
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

    public function get_answer($subject_id, $question_key){
        $db = new Database();

        $where = sprintf("subject_id='%s' and question_key='%s'", 
            $db->escape_string($subject_id), $db->escape_string($question_key));
        $select = 'answer';

        $rows = $db->select("survey_answer", $select, $where);

        if(empty($rows)){
            return array();
        }

        return $rows[0]['answer'];
    }
}
