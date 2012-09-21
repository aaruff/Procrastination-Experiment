<?php
class SubjectHTTP extends HTTP{
	/**
	 * Generates a redirect header to the page specified
	 * by the $page parameter.
	 * @param string $page
	 */
	public function redirect_subject($page){
		header("Location: ".WEB_ROOT."subject/$page");
	}
	
	/**
	 * Generates a redirect header to the subject login page.
	 */
	public function redirect_subject_to_login(){
		header("Location: ".WEB_ROOT."subject/login");
	}
}
