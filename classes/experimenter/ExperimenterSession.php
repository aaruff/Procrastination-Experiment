<?php
class ExperimenterSession extends Session{
	
	/**
	 * Retruns true if the experimenter session is active.
	 */
	public function experimenter_session_active(){
		if(!empty($_SESSION['experimenter_id'])){
			return true;
		}
	}
	
	/**
	 * Delete session ID
	 */
	public function unset_experimenter_session(){
		unset($_SESSION['experimenter_id']);
	}
	
	/**
	 * Returns experimenters session ID (Experimenter ID)
	 */
	public function get_experimenter_session_id(){
		return $_SESSION['experimenter_id'];
	}
	
}