<?php
class SubjectSession extends Session{
	
	/**
	 * Returns true if the subject session ID is set,
	 * otherwise false is returned.
	 */
	public function subject_session_active(){
		if(isset($_SESSION['subject_id']) && !empty($_SESSION['subject_id'])){
			return true;
        }
        return false;
	}
	
	/**
	 * Deletes the subject session ID
	 */
	public function unset_subject_session(){
		session_unset();
		session_destroy();
    }

    /**
     * Sets the subject session ID
     * @param string $session_id
     * @return string
     */
    public function set_session_id($session_id){
        $_SESSION['subject_id'] = $session_id;
    }
	
	/**
	 * Returns the subjects session ID (subject ID).
	 */
	public function get_subject_session_id(){
		return $_SESSION['subject_id'];
    }
    
    public function get_phrases(){
        return $_SESSION['phrases'];
    }

    public function is_phrases(){
        return isset($_SESSION['phrases']) && !empty($_SESSION['phrases']);
    }
}
