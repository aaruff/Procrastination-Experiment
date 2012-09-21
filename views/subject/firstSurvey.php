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
            <span>Survey Questions</span> 
        </div> 
			<form action="<?php echo $post_url; ?>" method="post"> 
			
			<!--  QUESTION 1 -->
			<div class="question">
                <label class="question">
                    <span class="question_number">1.</span> How many course are you taking?
                </label>
				<input type="text" class="textfield" name="question_1" placeholder="Course Load" value="<?php echo $question_1; ?>" />
				<label class="error"><?php echo $error_question_1;?></label>
			</div>
		
			<!--  QUESTION 2 -->
			<div class="question">
                <label class="question"> 
                    <span class="question_number">2.</span> What is your major?
                </label>
				<input type="text" class="textfield" name="question_2" placeholder="Major" value="<?php echo $question_2; ?>" />
				<label class="error"><?php echo $error_question_2; ?></label>
			</div>
				 
			<!--  QUESTION 3 -->
			<div class="question">
                <label class="question"> 
                    <span class="question_number">3.</span> What is your GPA? 
                </label>
				<input type="text" class="textfield" name="question_3" placeholder="GPA" value="<?php echo $question_3; ?>" />
				<label class="error"><?php echo $error_question_3; ?></label>
            </div>
				
			<!--  QUESTION 4 -->
			<div class="question">
                <label class="question"> 
                    <span class="question_number">4.</span> Over the course of the next week how many of each of the following do you have:
                </label>

                <div class="sub_question">
                    <label class="question">
                        1) Minor assignments?
                    </label>
                    <input type="text" class="textfield" name="question_4_sub_1" placeholder="Minor Assignments" value="<?php echo $question_4_sub_1; ?>" />
                    <label class="error"><?php echo $error_question_4_sub_1; ?></label>

                    <div class="sub_field">
                        <label>
                            Enter the deadlines for the above minor assignments:
                        </label>

                        <div class="inserted_date">
                            <div class="add_button_container" id="q_4-1_add_button">
                                <img class="add_remove" src="../resources/img/add.gif"/>
                            </div>
                            <input type="text" class="datetextfield textfield" name="question_4_sub_1_date_1" value="<?php echo $question_4_sub_1_date_1;?>" placeholder="mm/dd/yyyy" />
                            <label class="error">
                                <?php echo $error_question_4_sub_1_date_1; ?>
                            </label>
                        </div>
                        
                        <div id="dynamic_dates_4-1">
                        <?php 
                        //*********************************************************
                        // Include previously added dates
                        for($i = 2; $i <= 20; ++$i): 
                            $question_4_sub_1 = 'question_4_sub_1_date_'.$i; 
                            $error_question_4_sub_1 = 'error_question_4_sub_1_date_'.$i; 
                            if(!isset($$question_4_sub_1)){
                                break;
                            }?>

                        <div class="inserted_date" id="q_4-1_<?php echo $i;?>">
                            <div class="remove_button_container" data-date_index="<?php echo $i;?>">
                                <img class="add_remove" src="../resources/img/remove.gif" />
                            </div>
                            <input type="text" class="datetextfield textfield" name="<?php echo $question_4_sub_1;?>" value="<?php echo $$question_4_sub_1; ?>" placeholder="mm/dd/yyyy" />
                            <label class="error">
                                <?php echo $$error_question_4_sub_1;?>
                            </label>
                        </div>

                        <?php 
                            endfor;
                        //*********************************************************
                        ?>
                        </div><!-- dynamic date div -->
                    </div>
                </div>

                <div class="sub_question">
                    <label class="question">
                        2) major assignments / term papers?
                    </label>
                    <input type="text" class="textfield" name="question_4_sub_2" placeholder="Major Assignments" value="<?php echo $question_4_sub_2; ?>" />
                    <label class="error"><?php echo $error_question_4_sub_2; ?></label>

                    <div class="sub_field">
                        <label>
                            Enter the deadlines for the above major assignments:
                        </label>

                        <div class="inserted_date">
                            <div class="add_button_container" id="q_4-2_add_button">
                                <img class="add_remove" src="../resources/img/add.gif"/>
                            </div>
                            <input type="text" class="datetextfield textfield" name="question_4_sub_2_date_1" value="<?php echo $question_4_sub_2_date_1;?>" placeholder="mm/dd/yyyy" />
                            <label class="error"><?php echo $error_question_4_sub_2_date_1; ?></label>
                        </div>

                        <div id="dynamic_dates_4-2">
                        <?php 
                        //*****************************************************
                        // Include previously added dates
                        for($i = 2; $i <= 20; ++$i): 
                            $question_4_sub_2 = 'question_4_sub_2_date_'.$i; 
                            $error_question_4_sub_2 = 'error_question_4_sub_2_date_'.$i; 
                            if(!isset($$question_4_sub_2)){
                                break;
                            }
                        ?>

                        <div class="inserted_date" id="q_4-2_<?php echo $i?>">
                            <div class="remove_button_container" data-date_index="<?php echo $i;?>">
                                <img class="add_remove" src="../resources/img/remove.gif" />
                            </div>
                            <input type="text" class="datetextfield textfield" name="<?php echo $question_4_sub_2;?>" value="<?php echo $$question_4_sub_2; ?>" placeholder="mm/dd/yyyy" />
                            <label class="error">
                                <?php echo $$error_question_4_sub_2;?>
                            </label>
                        </div>

                        <?php 
                            endfor;
                        //*****************************************************
                        ?>
                        </div>
                    </div>
                </div>

                <div class="sub_question">
                    <label class="question">
                        3) exams?
                    </label>
                    <input type="text" class="textfield" name="question_4_sub_3" placeholder="Exam Count" value="<?php echo $question_4_sub_3; ?>" />
                    <label class="error"><?php echo $error_question_4_sub_3; ?></label>

                    <div class="sub_field" id="exam_date">
                        <label>
                            Enter the dates for the above exams:
                        </label>

                        <div class="inserted_date">
                            <div class="add_button_container" id="q_4-3_add_button">
                                <img class="add_remove" src="../resources/img/add.gif"/>
                            </div>
                            <input type="text" class="datetextfield textfield" name="question_4_sub_3_date_1" value="<?php echo $question_4_sub_3_date_1;?>" placeholder="mm/dd/yyyy" />
                            <label class="error"><?php echo $error_question_4_sub_3_date_1; ?></label>
                        </div>

                        <div id="dynamic_dates_4-3">
                        <?php 
                        //*********************************************************
                            // Include previously added dates
                            for($i = 2; $i <= 20; ++$i): 
                                $question_4_sub_3 = 'question_4_sub_3_date_'.$i; 
                                $error_question_4_sub_3 = 'error_question_4_sub_3_date_'.$i; 
                                if(!isset($$question_4_sub_3)){
                                    break;
                                }
                        ?>

                        <div class="inserted_date" id="q_4-3_<?php echo $i;?>">
                            <div class="remove_button_container" data-date_index="<?php echo $i;?>">
                                <img class="add_remove" src="../resources/img/remove.gif" />
                            </div>
                            <input type="text" class="datetextfield textfield" name="<?php echo $question_4_sub_3;?>" value="<?php echo $$question_4_sub_3; ?>" placeholder="mm/dd/yyyy">
                            <label class="error">
                                <?php echo $$error_question_4_sub_3;?>
                            </label>
                        </div>

                        <?php 
                            endfor;
                        //********************************************************
                        ?>
                        </div>
                    </div>
                </div>
			</div>	
			
			<!--  QUESTION 5 -->
			<div class="question"> 
				 <label class="question">
                    <span class="question_number">5.</span> Are you presently employed(either unemployed, paid, or unpaid)? 
				 </label>
				<select id="question_5" name='question_5'>
					<option value='' <?php echo ($question_5==="")?"selected":"";?>>Selection Required</option>
					<option value='unemployed' <?php echo ($question_5==="unemployed")?"selected":"";?>>unemployed</option>
					<option value='paid' <?php echo ($question_5==="paid")?"selected":"";?>>paid</option>
					<option value='unpaid' <?php echo ($question_5==="unpaid")?"selected":"";?>>unpaid</option>
				</select>
				<label class="error"><?php echo $error_question_5; ?></label>
			</div>
				 
			<!--  QUESTION 6 -->
			<div class="question">
				<label class="question">
                    <span class="question_number">6.</span> How many social/academic/sports clubs do you belong to?
				</label>
				<input type="text" class="textfield" name="question_6" placeholder="Activity Count" value="<?php echo $question_6; ?>" />
				<label class="error"><?php echo $error_question_6; ?></label>
			</div>
						
			<!-- QUESTION 7 -->		
			<div class="question">
                <label class="question"> 
                    <span class="question_number">7.</span> Over the course of the next week how much time (in hours) do you expect to allocate to: 
                </label>

				<div class="sub_question" id="question_7_1">
                    <label class="question"> 
                        1) your course work? 
                    </label>
                    <input type="text" class="textfield" name="question_7_sub_1" placeholder="Hours" value="<?php echo $question_7_sub_1; ?>" />
                    <label class="error"><?php echo $error_question_7_sub_1; ?></label>
                </div>

                <div class="sub_question" id="question_7_2">
                    <label class="question">
                        2) your job?
                    </label>
                    <input type="text" class="textfield" id="q7_2" name="question_7_sub_2" placeholder="Hours" value="<?php echo $question_7_sub_2; ?>" />
                    <label class="error"><?php echo $error_question_7_sub_2; ?></label>

                    <div class="sub_field">
                        <label>
                            Enter your workschedule over the next week: 
                        </label>

                        <div id="q_7-2_1">
                                <div class="add_button_container" id="add_schedule_7_2">
                                    <img id="question_7-2_add_button" class="add_remove" src="../resources/img/add.gif"/>
                                </div>

                                <label class="start_date_time">Start Date and Time:</label>
                                <input type="text" class="datetimetextfield textfield" name="question_7_sub_2_start_date_1" value="<?php echo $question_7_sub_2_start_date_1;?>" placeholder="mm/dd/yyyy hh:mm am/pm" />

                                <label class="end_date_time">End Date and Time:</label>
                                <input type="text" class="datetimetextfield textfield" name="question_7_sub_2_end_date_1" value="<?php echo $question_7_sub_2_end_date_1;?>" placeholder="mm/dd/yyyy hh:mm am/pm" />

                                <?php if(isset($error_question_7_sub_2_start_date_1) && !empty($error_question_7_sub_2_start_date_1)): ?>
                                    <label class="error"><?php echo "start date/time: ". $error_question_7_sub_2_start_date_1; ?></label>
                                <?php endif; ?>

                                <?php if(isset($error_question_7_sub_2_end_date_1) && !empty($error_question_7_sub_2_end_date_1)): ?>
                                    <label class="error"><?php echo "end date/time: ". $error_question_7_sub_2_end_date_1; ?></label>
                                <?php endif; ?>
                        </div>

                        <div id="dynamic_entries_7-2">
                                <?php 
                                //************************************************************************************************
                                // Add Rest of Workschedule Dates
                                for($i = 2; $i <= 20; ++$i): 
                                    $question_7_sub_2_start = sprintf('question_7_sub_2_start_date_%d', $i); 
                                    $question_7_sub_2_end = sprintf('question_7_sub_2_end_date_%d', $i); 

                                    $error_question_7_sub_2_start = sprintf('error_question_7_sub_2_start_date_%s', $i);
                                    $error_question_7_sub_2_end = sprintf('error_question_7_sub_2_end_date_%s', $i);

                                    if(!isset($$question_7_sub_2_start) || !isset($$question_7_sub_2_end)){
                                        continue;
                                    }
                                ?>
                            <div id="q_7-2_<?php echo $i;?>" class="inserted_date date_time">

                                <div class="remove_button_container" id="question_7-2_schedule_<?php echo $i; ?>" data-remove_id="<?php echo $i;?>">
                                    <img  class="add_remove" src="../resources/img/remove.gif"/>
                                </div>

                                <div class="schedule">
                                        <label class="start_date_time">Start Date and Time:</label>
                                        <input type="text" class="datetimetextfield textfield" name="<?php echo $question_7_sub_2_start;?>" value="<?php echo $$question_7_sub_2_start; ?>" placeholder="mm/dd/yyyy hh:mm am/pm">

                                        <label class="end_date_time">End Date and Time:</label>
                                        <input type="text" class="datetimetextfield textfield" name="<?php echo $question_7_sub_2_end;?>" value="<?php echo $$question_7_sub_2_end; ?>" placeholder="mm/dd/yyyy hh:mm am/pm">

                                        <?php if(!empty($$error_question_7_sub_2_start)): ?>
                                            <label class="error"><?php echo $$error_question_7_sub_2_start; ?></label>
                                        <?php endif;?>
                                        <?php if(!empty($$error_question_7_sub_2_end)): ?>
                                            <label class="error"><?php echo $$error_question_7_sub_2_end; ?></label>
                                        <?php endif;?>
                                </div>
                            </div>
                                <?php 
                                    endfor;
                                //************************************************************************************************
                                ?>
                        </div>
                    </div>
                </div>

                <div class="sub_question">
                    <label class="question">
                        3) social obligations and recreational activities?
                    </label>
                    <input type="text" class="textfield" name="question_7_sub_3" placeholder="Hours" value="<?php echo $question_7_sub_3; ?>" />
                    <label class="error"><?php echo $error_question_7_sub_3; ?></label>

                    <div class="sub_field">
                        <label>
                            Enter the date and time (over the next week) for which you plan to participate in social and recreational activities: 
                        </label>

                        <div id="q_7-3_1">
                            <div class="add_button_container" id="add_schedule_7_3">
                                <img class="add_remove" src="../resources/img/add.gif"/>
                            </div>

                            <label class="start_date_time">Start Date and Time:</label>
                            <input type="text" class="datetimetextfield textfield" name="question_7_sub_3_start_date_1" value="<?php echo $question_7_sub_3_start_date_1;?>" placeholder="mm/dd/yyyy hh:mm am/pm" />

                            <label class="end_date_time">End Date and Time:</label>
                            <input type="text" class="datetimetextfield textfield" name="question_7_sub_3_end_date_1" value="<?php echo $question_7_sub_3_end_date_1;?>" placeholder="mm/dd/yyyy hh:mm am/pm" />

                            <?php if(isset($error_question_7_sub_3_start_date_1) && !empty($error_question_7_sub_3_start_date_1)): ?>
                                <label class="error"><?php echo "start date/time: ". $error_question_7_sub_3_start_date_1; ?></label>
                            <?php endif; ?>

                            <?php if(isset($error_question_7_sub_3_end_date_1) && !empty($error_question_7_sub_3_end_date_1)): ?>
                                <label class="error"><?php echo "end date/time: ". $error_question_7_sub_3_end_date_1; ?></label>
                            <?php endif; ?>
                        </div>

                        <div id="dynamic_entries_7-3">
                                <?php 
                                //*********************************************************************************************
                                // Add Rest of Workschedule Dates
                                for($i = 2; $i <= 20; ++$i): 
                                    $question_7_sub_3_start = sprintf('question_7_sub_3_start_date_%d', $i); 
                                    $question_7_sub_3_end = sprintf('question_7_sub_3_end_date_%d', $i); 

                                    $error_question_7_sub_3_start = sprintf('error_question_7_sub_3_start_date_%s', $i);
                                    $error_question_7_sub_3_end = sprintf('error_question_7_sub_3_end_date_%s', $i);

                                    if(!isset($$question_7_sub_3_start) || !isset($$question_7_sub_3_end)){
                                        continue;
                                    }
                                ?>
                            <div id="q_7-3_<?php echo $i;?>" class="inserted_date">
                                <div class="remove_button_container" id="question_7-3_schedule_<?php echo $i; ?>" data-remove_id="q_7-3_<?php echo $i;?>">
                                    <img  class="add_remove" src="../resources/img/remove.gif"/>
                                </div>

                                <div class="schedule">
                                    <label class="start_date_time">Start Date and Time:</label>
                                    <input type="text" class="datetimetextfield textfield" name="<?php echo $question_7_sub_3_start;?>" value="<?php echo $$question_7_sub_3_start; ?>" placeholder="mm/dd/yyyy hh:mm am/pm">
                                
                                    <label class="end_date_time">End Date and Time:</label>
                                    <input type="text" class="datetimetextfield textfield" name="<?php echo $question_7_sub_3_end;?>" value="<?php echo $$question_7_sub_3_end; ?>" placeholder="mm/dd/yyyy hh:mm am/pm">

                                    <label class="error"><?php echo $$error_question_7_sub_3_start; ?></label>
                                    <label class="error"><?php echo $$error_question_7_sub_3_end; ?></label>
                                </div>
                            </div>
                            <?php 
                                endfor;
                            //**********************************************************************************************
                            ?>
                        </div>
                    </div>
                </div>

                <div class="sub_question">
                    <label class="question">
                        4) family obligations? 
                    </label>
                    <input type="text" class="textfield" name="question_7_sub_4" placeholder="Hours" value="<?php echo $question_7_sub_4; ?>" />
                    <label class="error"><?php echo $error_question_7_sub_4; ?></label>

                    <div class="sub_field">
                        <label>
                            Enter the date and time (over the next week) you plan to spend on family obligations: 
                        </label>

                        <div id="q_7-4_1">
                            <div class="add_button_container" id="add_schedule_7_4">
                                <img  class="add_remove" src="../resources/img/add.gif"/>
                            </div>

                            <label class="start_date_time">Start Date and Time:</label>
                            <input type="text" class="datetimetextfield textfield" name="question_7_sub_4_start_date_1" value="<?php echo $question_7_sub_4_start_date_1;?>" placeholder="mm/dd/yyyy hh:mm am/pm" />


                            <label class="end_date_time">End Date and Time:</label>
                            <input type="text" class="datetimetextfield textfield" name="question_7_sub_4_end_date_1" value="<?php echo $question_7_sub_4_end_date_1;?>" placeholder="mm/dd/yyyy hh:mm am/pm" />

                            <?php if(isset($error_question_7_sub_4_start_date_1) && !empty($error_question_7_sub_4_start_date_1)): ?>
                                <label class="error"><?php echo "start date/time: ". $error_question_7_sub_4_start_date_1; ?></label>
                            <?php endif;?>

                            <?php if(isset($error_question_7_sub_4_end_date_1) && !empty($error_question_7_sub_4_end_date_1)): ?>
                                <label class="error"><?php echo "end date/time: " . $error_question_7_sub_4_end_date_1; ?></label>
                            <?php endif;?>

                            <div id="dynamic_entries_7-4">
                                <?php 
                                //**********************************************************************************************
                                // Add Rest of Workschedule Dates
                                for($i = 2; $i <= 20; ++$i): 
                                    $question_7_sub_4_start = sprintf('question_7_sub_4_start_date_%d', $i); 
                                    $question_7_sub_4_end = sprintf('question_7_sub_4_end_date_%d', $i); 

                                    $error_question_7_sub_4_start = sprintf('error_question_7_sub_4_start_date_%s', $i);
                                    $error_question_7_sub_4_end = sprintf('error_question_7_sub_4_end_date_%s', $i);

                                    if(!isset($$question_7_sub_4_start) || !isset($$question_7_sub_4_end)){
                                        continue;
                                    }
                                ?>
                                <div id="q_7-4_<?php echo $i;?>" class="inserted_date">
                                    <div class="remove_button_container" id="question_7-4_schedule_<?php echo $i; ?>" data-remove_id="<?php echo $i;?>">
                                        <img  class="add_remove" src="../resources/img/remove.gif"/>
                                    </div>

                                    <div class="schedule">
                                        <label>Start Date and Time:</label>
                                        <input type="text" class="datetimetextfield textfield" name="<?php echo $question_7_sub_4_start;?>" value="<?php echo $$question_7_sub_4_start; ?>" placeholder="mm/dd/yyyy hh:mm am/pm">
                                    
                                        <label>End Date and Time:</label>
                                        <input type="text" class="datetimetextfield textfield" name="<?php echo $question_7_sub_4_end;?>" value="<?php echo $$question_7_sub_4_end; ?>" placeholder="mm/dd/yyyy hh:mm am/pm">

                                        <label class="error"><?php echo $$error_question_7_sub_4_end; ?></label>
                                        <label class="error"><?php echo $$error_question_7_sub_4_start; ?></label>
                                    </div>
                                    
                                </div>
                                <?php 
                                    //*******************************************************************************************
                                    endfor;
                                ?>
                            </div><!-- dynamic_entries_7-4 -->
                        </div> <!-- q_7-4_1 -->
                    </div> <!-- sub_field -->
                </div>
            </div>

			<!-- QUESTION 8 -->
			<div class="question">
                <label> 
                    <span class="question_number">8.</span> On a scale of 1 to 5 (with 1 being "hardly at all" and 5 being "very much so"), answer the following questions:
                </label>
                <div class="sub_question">
                    <div class="radio">
                        <label>
                            1) How conscientious are you?
                        </label>
                        <input type="radio" name="question_8_sub_1" value="1" <?php echo ($question_8_sub_1 === '1')?" checked":""; ?> />1
                        <input type="radio" name="question_8_sub_1" value="2" <?php echo ($question_8_sub_1 === '2')?" checked":""; ?> />2
                        <input type="radio" name="question_8_sub_1" value="3" <?php echo ($question_8_sub_1 === '3')?" checked":""; ?> />3
                        <input type="radio" name="question_8_sub_1" value="4" <?php echo ($question_8_sub_1 === '4')?" checked":""; ?> />4
                        <input type="radio" name="question_8_sub_1" value="5" <?php echo ($question_8_sub_1 === '5')?" checked":""; ?> />5
                        <label class="error"><?php echo $error_question_8_sub_1; ?></label>
                    </div>
                    
                    <div class="radio">
                        <label>
                            2) How often are you late turning in assignments?
                        </label>
                        <input type="radio" name="question_8_sub_2" value="1" <?php echo ($question_8_sub_2 === '1')?" checked":""; ?> />1
                        <input type="radio" name="question_8_sub_2" value="2" <?php echo ($question_8_sub_2 === '2')?" checked":""; ?> />2
                        <input type="radio" name="question_8_sub_2" value="3" <?php echo ($question_8_sub_2 === '3')?" checked":""; ?> />3
                        <input type="radio" name="question_8_sub_2" value="4" <?php echo ($question_8_sub_2 === '4')?" checked":""; ?> />4
                        <input type="radio" name="question_8_sub_2" value="5" <?php echo ($question_8_sub_2 === '5')?" checked":""; ?> />5
                        <label class="error"><?php echo $error_question_8_sub_2; ?></label>
                    </div>
    
                    <div class="radio">
                        <label>
                            3) How often are you on time for appointments
                        </label>
                        <input type="radio" name="question_8_sub_3" value="1" <?php echo ($question_8_sub_3 === '1')?" checked":""; ?> />1
                        <input type="radio" name="question_8_sub_3" value="2" <?php echo ($question_8_sub_3 === '2')?" checked":""; ?> />2
                        <input type="radio" name="question_8_sub_3" value="3" <?php echo ($question_8_sub_3 === '3')?" checked":""; ?> />3
                        <input type="radio" name="question_8_sub_3" value="4" <?php echo ($question_8_sub_3 === '4')?" checked":""; ?> />4
                        <input type="radio" name="question_8_sub_3" value="5" <?php echo ($question_8_sub_3 === '5')?" checked":""; ?> />5
                        <label class="error"><?php echo $error_question_8_sub_3; ?></label>
                    </div>
                </div>
			</div>
				  
			<!-- QUESTION 9 -->
			<div class="question">
                <label class="question">
                    <span class="question_number">9.</span> On a scale from 1 to 5(with 1 being "strongly disagree" and 5 being "strongly agree")
                    rate how closely you identify with the following statements:
                </label>
                <div class="sub_question">
                    <div class="radio">
                        <label>
                            1) Unexpected things which require my time and attention always seem to occur.
                        </label>
                        <input type="radio" name="question_9_sub_1" value="1" <?php echo ($question_9_sub_1 === '1')?" checked":""; ?>>1
                        <input type="radio" name="question_9_sub_1" value="2" <?php echo ($question_9_sub_1 === '2')?" checked":""; ?>>2
                        <input type="radio" name="question_9_sub_1" value="3" <?php echo ($question_9_sub_1 === '3')?" checked":""; ?>>3
                        <input type="radio" name="question_9_sub_1" value="4" <?php echo ($question_9_sub_1 === '4')?" checked":""; ?>>4
                        <input type="radio" name="question_9_sub_1" value="5" <?php echo ($question_9_sub_1 === '5')?" checked":""; ?>>5
                        <label class="error"><?php echo $error_question_9_sub_1; ?></label>
                    </div>
                    <div class="radio">
                        <label>
                            2) Sometimes I am not as dependable or reliable as I should be.
                        </label>
                        <input type="radio" name="question_9_sub_2" value="1" <?php echo ($question_9_sub_2 === '1')?" checked":""; ?>/>1
                        <input type="radio" name="question_9_sub_2" value="2" <?php echo ($question_9_sub_2 === '2')?" checked":""; ?>/>2
                        <input type="radio" name="question_9_sub_2" value="3" <?php echo ($question_9_sub_2 === '3')?" checked":""; ?>/>3
                        <input type="radio" name="question_9_sub_2" value="4" <?php echo ($question_9_sub_2 === '4')?" checked":""; ?>/>4
                        <input type="radio" name="question_9_sub_2" value="5" <?php echo ($question_9_sub_2 === '5')?" checked":""; ?>/>5
                        <label class="error"><?php echo $error_question_9_sub_2; ?></label>
                    </div>
                    
                    <div class="radio">
                        <label>
                            3) I follow a schedule.
                        </label>
                        <input type="radio" name="question_9_sub_3" value="1" <?php echo ($question_9_sub_3 === '1')?" checked":""; ?>/>1
                        <input type="radio" name="question_9_sub_3" value="2" <?php echo ($question_9_sub_3 === '2')?" checked":""; ?>/>2
                        <input type="radio" name="question_9_sub_3" value="3" <?php echo ($question_9_sub_3 === '3')?" checked":""; ?>/>3
                        <input type="radio" name="question_9_sub_3" value="4" <?php echo ($question_9_sub_3 === '4')?" checked":""; ?>/>4
                        <input type="radio" name="question_9_sub_3" value="5" <?php echo ($question_9_sub_3 === '5')?" checked":""; ?>/>5
                        <label class="error"><?php echo $error_question_9_sub_3; ?></label>
                    </div>
                    
                    <div class="radio">
                        <label>
                            4) I never seem able to get organized.
                        </label> 
                        <input type="radio" name="question_9_sub_4" value="1" <?php echo ($question_9_sub_4 === '1')?" checked":""; ?>/>1
                        <input type="radio" name="question_9_sub_4" value="2" <?php echo ($question_9_sub_4 === '2')?" checked":""; ?>/>2
                        <input type="radio" name="question_9_sub_4" value="3" <?php echo ($question_9_sub_4 === '3')?" checked":""; ?>/>3
                        <input type="radio" name="question_9_sub_4" value="4" <?php echo ($question_9_sub_4 === '4')?" checked":""; ?>/>4
                        <input type="radio" name="question_9_sub_4" value="5" <?php echo ($question_9_sub_4 === '5')?" checked":""; ?>/>5
                        <label class="error"><?php echo $error_question_9_sub_4; ?></label>
                    </div>
                    
                    <div class="radio">
                        <label>
                            5) I always pay attention to details.
                        </label>
                        <input type="radio" name="question_9_sub_5" value="1" <?php echo ($question_9_sub_5 === '1')?" checked":""; ?>/>1
                        <input type="radio" name="question_9_sub_5" value="2" <?php echo ($question_9_sub_5 === '2')?" checked":""; ?>/>2
                        <input type="radio" name="question_9_sub_5" value="3" <?php echo ($question_9_sub_5 === '3')?" checked":""; ?>/>3
                        <input type="radio" name="question_9_sub_5" value="4" <?php echo ($question_9_sub_5 === '4')?" checked":""; ?>/>4
                        <input type="radio" name="question_9_sub_5" value="5" <?php echo ($question_9_sub_5 === '5')?" checked":""; ?>/>5
                        <label class="error"><?php echo $error_question_9_sub_5; ?></label>
                    </div>
                </div>
			</div>
				 
			<!-- QUESTION 10 -->
			<div class="question">
                <label>
                    <span class="large_question"><span class="question_number">10.</span> Suppose that you win 10 certificates, each of which can be used (once) to receive a 
                    dream restaurant night. On each such night, you and a companion will get the best table 
                    and an unlimited budget for food and drink at a restaurant of your choosing. 
                    There will be no cost to you: all payments including gratuities come as part of the prize. 
                    The certificates are available for immediate use, starting tonight, and there is an absolute 
                    guarantee that they will be honored by any restaurant you select if they are used within a two year window. 
                    However if they are not used up within this two year period, any that remain are valueless. 
                    The questions below concern how many of the certificates you would ideally like to use in each year, 
                    how tempted you would be to depart from this ideal, and what you expect you would do in practice:</span>
                </label>
                <div class="sub_question">
                    <label class="question">
                        From your current perspective, how many of the ten certificates would you ideally like to use in year 1?
                    </label>
				<input type="text" class="textfield" name="question_10" placeholder="Certificate Count" value="<?php echo $question_10; ?>" />
                <label class="error"><?php echo $error_question_10; ?></label>
                </div>
			</div>
				 
				
			<!-- QUESTION 11 -->
			<div class="question">	
                <label class="question">
                    <span class="question_number">11.</span> Continue with the scenario of Question 10. Some people might be tempted to depart from their ideal allocation in Question 10.
                </label>
                <div class="sub_question">
                    <div class="radio">1) I would have no temptation in either direction.</div>
                    <div class="radio">2) I would be somewhat/strongly tempted to use more certificates in the first year than would be ideal.</div>
                    <div class="radio">3) I would be strongly/somewhat tempted to keep more certificates for use in the second year than would be ideal.</div>
                </div>
                <div class="sub_field">
                    <label class="question">Which of the following best describes you:</label>
                    <select name="question_11">
                        <option value="" <?php echo ($question_11 === '')?"selected":""; ?>>Selection Required</option> 
                        <option value="1"<?php echo ($question_11 === '1')?"selected":""; ?>>1</option> 
                        <option value="2" <?php echo ($question_11 === '2')?"selected":""; ?>>2</option>
                        <option value="3" <?php echo ($question_11 === '3')?"selected":""; ?>>3</option>
                    </select><label class="error"><?php echo $error_question_11; ?></label>
                </div>
			</div>
				
			<!-- QUESTION 12 -->
			<div class="question">
                <label class="question">
                    <span class="question_number">12.</span> Continue with the scenario of Question 10. If you were to give in to your temptation, 
                    how many certificates do you think you would use in year 1 as opposed to year 2?
                </label>
                <div class="sub_field">
                    <label class="question">
                        If you answered Yes to Question 10(1), please enter the response given in Question 10.
                    </label>
                    <input type="text" class="textfield" name="question_12" placeholder="Certificate Count" value="<?php echo $question_12; ?>" />
                    <label class="error"><?php echo $error_question_12; ?></label>
                </div>
			</div>
			
			<!-- QUESTION 13 -->
			<div class="question"> 
                <label class="question">
                        <span class="question_number">13.</span> Continue with the scenario of Question 10. Based on your most accurate forecast of how you think you would actually behave, 
                        how many of the nights would you end up using in year 1?
                </label>
				<input type="text" class="textfield" name="question_13" placeholder="Certificate Count" value="<?php echo $question_13; ?>" />
				<label class="error"><?php echo $error_question_13; ?></label>
			</div> 
				<input type="submit" name="submit" value="Submit Survey" class="submit_button"/> 
			</form>
		</div>	
</body> 
</html> 
