<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<title>First Questionnaire</title> 
	<link href='../resources/css/survey.css' rel='stylesheet' type='text/css' /> 
    <link href="../resources/js/ui/css/smoothness/jquery-ui-1.8.11.custom.css" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="../resources/js/ui/js/jquery-1.5.1.min.js"></script> 
    <script type="text/javascript" src="../resources/js/ui/js/jquery-ui-1.8.11.custom.min.js"></script> 
    <script type="text/javascript"  src="../resources/js/jquery-ui-timepicker-addon.js"></script>
    <script>
		$(function(){
		    $('#content').hide().fadeIn('slow');
		
		    $('.datetimetextfield').datetimepicker({
		        ampm: true
		    });
		
		    $('.datetextfield').datepicker();
		
		});
</script>
</head> 
<body> 
	
	<div id="content"> 
        <div id="heading"> 
            <h3>Second Survey Question</h3> 
        </div> 
			<form action="<?php echo $post_url; ?>" method="post"> 
			
			<!-- QUESTION 18 -->		
			<div class="question">
				<label> 18) On a scale from 0 to 100, how likely do you think each of the following events are?</label>
				<div class="sub_question">
					<label> 1. I will NOT complete the task. 
						<input type="text" class="long_text_field" name="question_18_sub_1" placeholder="Number between 0 and 100" value="<?php echo $question_18_sub_1; ?>" /></label>
						<div class="error"><?php echo $error_question_18_sub_1; ?></div>
					<label> 2. I will complete the task. 
						<input type="text" class="long_text_field" name="question_18_sub_2" placeholder="Number between 0 and 100" value="<?php echo $question_18_sub_2; ?>" /></label>
						<div class="error"><?php echo $error_question_18_sub_2; ?></div>
						<span><label>Note: All of your entries must up to 100.</label></span>
				</div>
            </div> 
			<div class="question">
				<label> 19) Assuming that you successfully complete the task, when do you think is the most likely time that you will do so?</label>
				<div class="sub_question">
					<label>
						<input type="text" class="datetimetextfield textfield" name="question_19" placeholder="mm/dd/yyyy hh:mm am/pm" value="<?php echo $question_19; ?>" /></label>
						<div class="error"><?php echo $error_question_19; ?></div>
				</div>
            </div> 
				
			<input type="submit" name="submit" value="Submit Survey" class="submit_button"/> 
			</form>
		</div>	
</body> 
</html> 
