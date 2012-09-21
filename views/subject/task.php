<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<title>First Questionnaire</title> 
	<link href='../resources/css/task.css' rel='stylesheet' type='text/css' /> 
</head> 
<body> 
	<div id="content"> 
        <div id="heading">
        	<!-- task_number  --> 
           <label class="heading">Task</label>
           <label>
                <p>In order to complete this task you must solve the problem given to you by entering the words below in alphabetical order, 
                with the following restrictions:</p>
           </label>
            <label>
            <ul>
                <li class="star">You must complete this task by <?php echo $deadline;?> (Eastern).</li>
                <li class="star">You must solve this problem by <?php echo $problem_time_limit;?> (Eastern), or you will be issued a new one.</li>
                <li class="warn">If you close or refresh your browser, or log in again at a later time, you will be issued a new problem. </li>
            </ul>
            </label>
        </div> 
        <div class="float_center">
        <form action="<?php echo $post_url; ?>" method="post"> 
            <div class="submit_button">
                <label>Select the SUBMIT button to submit the solution to you problem:</label>
                <input type="submit" name="button" value="Submit Task Solution" class="button"/>
              <div class="error">
                <label class="error"><?php echo $general_error;?></label>
              </div>
            </div>
            <div class="left_column"> 
                <!-- PHRASES (1-50)-->
                <?php for($i = 1; $i <= 50; ++$i): 
                    $phrase_id = "phrase_"."$i";
                ?>
                <div class="phrase">
                    <label><?php echo $i.") "; ?></label>
                    <input type="text" class="textfield" maxlength="20" name="<?php echo $phrase_id;?>" placeholder="" value="<?php echo $$phrase_id; ?>" />
                </div>
                <?php endfor;?>
            </div>	
            <div class="left_column"> 
                <!-- PHRASES (1-50)-->
                <?php for($i = 51; $i <= 100; ++$i): 
                    $phrase_id = "phrase_"."$i";
                ?>
                <div class="phrase">
                    <label><?php echo $i.") "; ?></label>
                    <input type="text" class="textfield" maxlength="20" name="<?php echo $phrase_id;?>" placeholder="" value="<?php echo $$phrase_id; ?>" />
                </div>
                <?php endfor;?>
            </div>	
            
            <!-- PHRASES 101-150)-->
            <div class="right_column">
                <?php for($i = 101; $i <= 150; ++$i): 
                    $phrase_id = "phrase_".$i;
                ?>
                <div class="phrase">
                    <label><?php echo $i.") "; ?></label>
                    <input type="text" class="textfield" maxlength="20" name="<?php echo $phrase_id;?>" placeholder="" value="<?php echo $$phrase_id; ?>" />
                </div>
                <?php endfor;?>
            </div>

            <div class="center_column">
                <img src ="<?php echo $img_src ."?".time();?>" \> 
            </div>

            </form>
        </div>
    <div class="footer"></div>
    </div>
</body> 
</html> 
