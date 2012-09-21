<?php session_start(); ?>
<?php	
	include '../config/config.php';
	
	function __autoload($class_name){
		$classes = array( 
			"../classes/".$class_name.'.php', 
			"../classes/subject/".$class_name.'.php', 
	        "../controller/subject/".$class_name.'.php', 
	        "../model/subject/".$class_name.'.php',
		 	"../views/subject/".$class_name.'.php',
   		); 
   		
   		foreach($classes as $file){
   			if(file_exists($file)){
   				include $file;
   				return true;
   			}
   		}
	}
	
	$experimenter_login = new SubjectLogin('login');
	$experimenter_login->process_page_request();