<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<title>Generate Output File</title> 
	<link href='../resources/css/output_file.css' rel='stylesheet' type='text/css' /> 
</head> 
<body> 
    <div id="parent_container">
        <div id="navigation"> 
            <ul>
                <li><a href="viewSubjects.php"><img src="../resources/img/home.png"/>View Treatments</a></li>
                <li><a href="createTreatment.php"><img src="../resources/img/add_treatment.png"/>New Treatment</a></li>
            </ul> 
        </div>
        
        <div id="content"> 
            <div id="heading"> 
                <h2>Generate Output File</h2> 
            </div> 
            <form action="<?php echo $post_url; ?>" method="post"> 
                <div class="question">
                    <?php if(!isset($file_location)):?>
                        <label>
                           <p>Enter a treatment range or a list of treatments to be included in the output file.</p> 
                            <p class="indent"><span>List Format:</span> a, b, c (where a b and c are integers)</p>
                            <p class="indent"><span>Range Format:</span> a-z (where a and z are integers and a is less than z)</p>
                        </label>
                        <div id="entry">
                            <input type="text" class="text_field" maxlength="30" name="treatment_selection" placeholder="a-z or a,b,c" value="<?php echo $treatment_selection; ?>" />
                            <label class="error"><?php echo $error_treatment_selection?></label>
                        </div>
                        <input type="submit" name="submit" value="Submit Your Treatment Selection" class="button"/> 
                    <?php else:?>
                        <a href="<?php echo $file_location;?>">Excel CSV File</a>
                    <?php endif;?>
                </div>
            </form>
            <div class="footer"></div>
        </div>	
    </div>
</body> 
</html> 
