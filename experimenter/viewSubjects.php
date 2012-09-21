<?php session_start(); ?>
<?php
	include '../config/config.php';
	
	function __autoload($class_name){
		$classes = array( 
			"../classes/".$class_name.'.php',
			"../classes/experimenter/".$class_name.'.php',
	        "../controller/experimenter/".$class_name.'.php', 
	        "../model/experimenter/".$class_name.'.php',
		 	"../views/".$class_name.'.php',
   		); 
   		
   		foreach($classes as $file){
   			if(file_exists($file)){
   				include $file;
   				return true;
   			}
   		}
	}
	
	$create_treatment = new ViewSubjects('viewSubjects');
	$create_treatment->process_page_request();
