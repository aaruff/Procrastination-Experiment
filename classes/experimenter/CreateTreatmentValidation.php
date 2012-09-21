<?php
class CreateTreatmentValidation extends Validate{
	private $db;
	
	public function __construct(){
		$this->db = new TreatmentCreationModel();
	}
	
	/**
	 * Return false if the date/time string format is invalid or
	 * if the date and time are in the past, otherwise true is returned.
	 * @param string date_time 
	 * @param integer format (24 or 12)
	 * @return boolean
	 * @see Validate::is_date_time()
	 */
	public function is_date_time($date_time, $format = 12){
		// date format invalid
		if(!parent::is_date_time($date_time, $format)){
			return false;
		}
		
		// date scheduled lies in the past
		if(strtotime($date_time) <= strtotime("now")){
			return false;
		}
		
		return true;
	}
	
}