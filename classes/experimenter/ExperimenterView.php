<?php
class ExperimenterView extends View{
	
	private $experimenter_view_path = '../views/experimenter/';
	
	public function __construct(){
		parent::__construct($this->experimenter_view_path);
	}
}