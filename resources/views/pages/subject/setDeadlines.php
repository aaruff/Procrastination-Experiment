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
    <script type="text/javascript"  src="../resources/js/survey.js"></script>
</head> 
<body> 
	
	<div id="content"> 
        <div id="heading"> 
            <h3>Set Deadline</h3> 
        </div> 
			<form action="<?php echo $post_url; ?>" method="post"> 
			<!--DEADLINE 1 -->
			<div class="question">
			<p>The experiment ends on <b><?php echo $deadline;?></b>. However, you may impose 
			an earlier deadline for the task if you wish. If so, please do so now. 
			Keep in mind that the deadline will be strictly enforced. For example, 
			if you impose a deadline for tomorrow at 9:00PM and you do not complete 
			the task by that time, then you will not be able to work on the task and 
			will receive no payment.</p>
				<label>Task Deadline (MM/DD/YYYY HH:MM AM|PM): </label>
				<input type="text" class="datetimetextfield" maxlength="30" name="deadline_1" placeholder="MM/DD/YYYY HH:MM AM|PM" value="<?php echo $deadline_1; ?>" />
				<label class="error"><?php echo $error_deadline_1?></label>
			</div>
				<input type="submit" name="submit" value="Submit Your Deadline" class="submit_button"/> 
			</form>
		</div>	
</body> 
</html> 
