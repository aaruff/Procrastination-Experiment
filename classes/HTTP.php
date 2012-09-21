<?php
include '../config/config.php';
class HTTP{
	public function __construct(){}
	
	/**
	 * Returns true request method was a post, otherwise
	 * false is returned.
	 */
	public function is_post_request(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			return true;
		}
		
		return false;
	}
	
	/**
	 * Returns true if the http request is a GET request,
	 * otherwise false is returned.
	 */
	public function is_get_request(){
		if($_SERVER['REQUEST_METHOD'] === 'GET'){
			return true;
		}
		
		return false;
	}
}