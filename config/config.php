<?php
    defined("WEB_ROOT") or define("WEB_ROOT", 'http://localhost/procrastination/');
    defined("WEB_DIR") or define("WEB_DIR", '/Users/aruff/Projects/web_projects/procrastination/');
    
    defined("SUBJECT_DIR") or define("SUBJECT_DIR", 'subject/');
    defined("EXPERIMENTER_DIR") or define("EXPERIMENTER_DIR", 'experimenter/');
    defined("IMAGE_DIR") or define("IMAGE_DIR", WEB_DIR . 'resources/img/subjects/');
	defined("IMAGE_WEB_DIR") or define("IMAGE_WEB_DIR", WEB_ROOT . 'resources/img/subjects/');
    defined("TIME_ZONE") or define("TIME_ZONE", 'US/Eastern');
    date_default_timezone_set("US/Eastern");
    
    defined("TASK_FONT") or define("TASK_FONT", 'Arial.ttf');

   // putenv('GDFONTPATH=/usr/share/fonts/truetype/freefont/');
    putenv('GDFONTPATH=/Library/Fonts/Microsoft/');
?>
