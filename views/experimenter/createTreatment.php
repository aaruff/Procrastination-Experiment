<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<title>Create A Treatment</title> 
    <link href='../resources/css/create_treatment.css' rel='stylesheet' type='text/css' /> 
    <link href="../resources/js/ui/css/smoothness/jquery-ui-1.8.11.custom.css" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="../resources/js/ui/js/jquery-1.5.1.min.js"></script> 
    <script type="text/javascript" src="../resources/js/ui/js/jquery-ui-1.8.11.custom.min.js"></script> 
    <script type="text/javascript" src="../resources/js/jquery-ui-timepicker-addon.js"></script>
</head> 
<body> 
    <div id="parent_container">
        <div id="navigation"> 
            <ul>
                <li><a href="./viewSubjects.php"><img src="../resources/img/home.png"/>View Treatments</a></li> 
                <li><a href="./outputFile.php"><img src="../resources/img/add_doc.png"/>Output File</a></li> 
            </ul> 
        </div>

        <div id="content"> 	
            <form action="<?php echo $post_url; ?>" method="post"> 
                <div>
                <label><h2>Treatment <?php echo $treatment_id;?></h2></label>
                    <label class="error"><?php echo $treatment_id_error; ?></label>
                </div>

                <div class="question">
                    <label>
                        How many subjects are in this treatment? 
                    </label>
                    <input type="text" name="number_subjects" placeholder="Number of treatments" class="text_field" value="<?php echo $number_subjects;?>"/>
                    <label class="error"><?php echo $number_subjects_error; ?></label> 
                </div>
                 
                <div>
                        <!-- SUBJECT SET REMINDERS --> 
                        <div class="question">
                        <label><h3>Deadline</h3></label> 
                            <label>Allow subjects to set their own reminder:
                                <select name="subject_deadline_enabled"> 
                                    <option value="yes"  
                                        <?php echo ($subject_deadline_enabled === "yes")?"selected":""; ?>>Yes</option> 
                                    <option value="no" 
                                        <?php echo ($subject_deadline_enabled === "no")?"selected":""; ?>>No</option> 
                                </select>
                            </label>
                            <label class="error"><?php echo $subject_deadline_enabled_error; ?></label>
                        </div>
                        
                        <!-- FIRST TASK DEADLINE-->
                        <div class="sub_question"> 
                            <label>What is the deadline for the first task?</label> 
                            <input type="text" class="dtime" name="first_experimenter_set_deadline" placeholder="mm/dd/yyyy hh:mm am/pm" value="<?php echo $first_experimenter_set_deadline; ?>" /> 
                            <label class="error"><?php echo $first_experimenter_set_deadline_error; ?></label>
                        </div> 
                </div>
                        
                    <!-- PROBLEM MAX TIME LIMIT -->
                <div>
                    <label>Set the maximum time a subject can take to complete a problem.</label> 
                    <input type="text" class="text_field time" name="problem_time_limit" placeholder="hh:mm" value="<?php echo $problem_time_limit; ?>" /> 
                    <label class="error"><?php echo $problem_time_limit_error; ?></label> 
                </div>
             
                <!-- REMINDER NOTIFICATION -->
                <div> 
                    <div class="question">
                        <label><h3>Reminders</h3></label> 
                        <label>Allow Subjects to request reminders:
                            <select id="reminder" name="enable_reminder_notification"> <option value="yes" <?php echo ($enable_reminder_notification === "yes")?"selected":""; ?>>Yes</option> 
                                <option value="no" <?php echo ($enable_reminder_notification === "no")?"selected":""; ?>>No</option> 
                            </select>
                        </label>
                    </div>

                    <div id="reminder_field">
                        <div class="reminder_sub_question">
                            <label>Set the time at which subjects will recieve reminders 
                                <input type="text" class="text_field timeampm" name="reminder_delivery_time" placeholder="hh:mm am/pm" value="<?php echo $reminder_delivery_time; ?>" />
                            </label>
                            <label class="error"><?php echo $reminder_delivery_time_error; ?></label> 
                        </div>
                        <div class="reminder_sub_question">
                            <label>Set the reminder cost in dollars:
                            <input type="text" name="reminder_cost" class="text_field" placeholder="Reminder cost" value="<?php echo $reminder_cost; ?>" /></label>
                            <label class="error"><?php echo $reminder_cost_error; ?></label> 
                        </div>
                    </div>
                    <div class="submit_button">
                        <input type="hidden" name="treatment_id"  value="<?php echo $treatment_id;?>" />
                        <input type="submit" id="button" name="submit" value="Create a Treatment" />
                    </div>
                </div>
                
            </form> 
        </div> 
    </div>
<script>
  $("#reminder").click(function () {
    $("p").fadeOut("slow");
    });
</script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.dtime').datetimepicker({
            ampm: true
        });

        $('.timeampm').timepicker({
            ampm: true
        });

        $('.time').timepicker({
        });

        $('#reminder').change(function() {
            reminder_state = $(this).val();
            if(reminder_state == 'no'){
                $(".reminder_sub_question").fadeOut("fast");
            }else{
                $(".reminder_sub_question").fadeToggle("fast");
            }
       });
    });
</script>
</body> 
</html> 
