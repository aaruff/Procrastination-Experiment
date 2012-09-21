<?php
class View{
	
	private $view_path;
	
	public function __construct($view_path){
		$this->view_path = $view_path;
	}
	
	/**
	 * Populates the fields specified by $page_parameters, and
	 * displays the HTML view, specified by $page.
	 * @param string $page
	 * @param array $page_parameters
	 */
	public function display($page, array $page_parameters = array()){
		
		foreach($page_parameters as $key=>$value){
			$$key=$value;
		}
		
		include $this->view_path . "$page.php";
	}
}
