<?php
include '../config/config.php';
class Session{
	public function __construct(){}
	
	/**
	 * Save value to session array via key, value
	 * parameters. 
	 * Key value must not be 0, false, or an empty string.
	 * @param mixed $key
	 * @param mixed $value
	 * @return boolean
	 */
	public function save($key, $value){
		if(empty($key)){
			return false;
		}
		
		$_SESSION[$key] = $value;
		return true;
	}
	
	
}