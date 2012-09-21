<?php
class SubjectView extends View {
	private $subject_view_path = '../views/subject/';
	
	public function __construct(){
		parent::__construct($this->subject_view_path);
	}
}