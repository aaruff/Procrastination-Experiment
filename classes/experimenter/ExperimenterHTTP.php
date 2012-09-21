<?php
class ExperimenterHTTP extends HTTP{
	/**
	 * Generates a redirect header to the page specified
	 * by the $page parameter.
	 * @param string $page
	 */
	public function redirect_experimenter($page){
		header("Location: ".WEB_ROOT."experimenter/$page");
	}
	
	/**
	 * Generates a redirect header to the subject login page.
	 */
	public function redirect_experimenter_to_login(){
		header("Location: ".WEB_ROOT."experimenter/login.php");
	}
}