<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<title>First Questionnaire</title> 
	<link href='../resources/css/survey.css' rel='stylesheet' type='text/css' /> 
</head> 
<body> 
	<div id="deadline_content"> 
        <div id="heading"> 
            <h2>Reminder Cost</h2> 
        </div> 
        <form action="<?php echo $post_url; ?>" method="post"> 
        
        <div class="question">
            <label><p>You can recieve daily email reminders at <?php echo $reminder_time;?>, at a cost of $<?php echo $reminder_cost;?> to you.</p>
                Would you like to recieve email reminders:
                <select name='purchase_reminder'>
                    <option value='' <?php echo ($purchase_reminder==="")?"selected":"";?>>Selection Required</option>
                    <option value='yes' <?php echo ($purchase_reminder==="yes")?"selected":"";?>>Yes</option>
                    <option value='no' <?php echo ($purchase_reminder==="no")?"selected":"";?>>No</option>
                </select>
            </label>
        </div> 
            
        <input type="submit" name="submit" value="Submit Choice" class="button"/> 
        </form>
    </div>	
</body> 
</html> 
