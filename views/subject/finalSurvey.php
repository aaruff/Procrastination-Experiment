<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<title>Final Survey</title> 
	<link href='../resources/css/survey.css' rel='stylesheet' type='text/css' /> 
</head> 
<body> 
	<div id="content"> 
        <div id="heading"> 
           <label class="heading">Final Survey</label>
        </div> 
        <div>
           <label id="sub_heading"> You have <?php echo $task;?> the task.
                Looking back over the duration of the experiment, please list any unexpected events that 
                occurred and provide an estimate of how much time was required to attend to them.
            </label>
        </div>

		<form action="<?php echo $post_url; ?>" method="post"> 
			<!--  QUESTION 20 -->
			<div class="question">
                <label><span class="question_number">1.</span> At the beginning of the experiment, you reported that you anticipated having completed
                    <?php echo $question_4_sub_1;?> minor assignments. Looking back, did you have more or less than anticipated?
                </label>
                    <select name="question_20">
                        <option value=""
                        <?php echo ($question_20 === '')?" selected":""; ?>>Selection Required</option> 
                        <option value="same" 
                        <?php echo ($question_20 === 'same')?" selected":""; ?>>Same</option> 
                        <option value="more" 
                        <?php echo ($question_20 === 'more')?" selected":""; ?>>More</option>
                        <option value="less" 
                        <?php echo ($question_20 === 'less')?" selected":""; ?>>Less</option>
                    </select>
                    <label class="error"><?php echo $error_question_20; ?></label>
				<div class="sub_question">
					<label> If you spent more or less time on the above, please specify how many hours in total were spent:
                        <input type="text" class="textfield" name="question_20_sub_1" placeholder="Hours Total" value="<?php echo $question_20_sub_1; ?>" />
                    </label>
                    <div class="error"><?php echo $error_question_20_sub_1; ?></div>
                </div>
            </div>	
				 
			<!--  QUESTION 21 -->
			<div class="question">
                <label><span class="question_number">2.</span> At the beginning of the experiment, you reported that you anticipated having completed
                <?php echo $question_4_sub_2;?> major assignments / term papers. Looking back, did you have more or less than anticipated?</label>
                <select name="question_21">
                    <option value=""
                    <?php echo ($question_21 === '')?" selected":""; ?>>Selection Required</option> 
                    <option value="same" 
                    <?php echo ($question_21 === 'same')?" selected":""; ?>>Same</option> 
                    <option value="more" 
                    <?php echo ($question_21 === 'more')?" selected":""; ?>>More</option>
                    <option value="less" 
                    <?php echo ($question_21 === 'less')?" selected":""; ?>>Less</option>
                </select><label class="error"><?php echo $error_question_21; ?></label>
				<div class="sub_question">
					<label> If you spent more or less time on the above, please specify how many hours in total were spent:
						<input type="text" class="textfield" name="question_21_sub_1" placeholder="Hours Total" value="<?php echo $question_21_sub_1; ?>" /></label>
                        <div class="error"><?php echo $error_question_21_sub_1; ?></div>
                </div>
            </div>	

			<!--  QUESTION 22 -->
			<div class="question">
                <label><span class="question_number">3.</span> At the beginning of the experiment, you reported that you anticipated having completed
                <?php echo $question_4_sub_3;?> exams. Looking back, did you have more or less than anticipated?</label>
                <select name="question_22">
                    <option value=""
                    <?php echo ($question_22 === '')?" selected":""; ?>>Selection Required</option> 
                    <option value="same" 
                    <?php echo ($question_22 === 'same')?" selected":""; ?>>Same</option> 
                    <option value="more" 
                    <?php echo ($question_22 === 'more')?" selected":""; ?>>More</option>
                    <option value="less" 
                    <?php echo ($question_22 === 'less')?" selected":""; ?>>Less</option>
                </select><label class="error"><?php echo $error_question_22; ?></label>
				<div class="sub_question">
					<label> If you spent more or less time on the above, please specify how many hours in total were spent:
						<input type="text" class="textfield" name="question_22_sub_1" placeholder="Hours Total" value="<?php echo $question_22_sub_1; ?>" /></label>
                        <div class="error"><?php echo $error_question_22_sub_1; ?></div>
                </div>
            </div>	


			<!--  QUESTION 23 -->
			<div class="question">
                <label><span class="question_number">4.</span> At the beginning of the experiment, you reported that you anticipated spending 
                <?php echo $question_7_sub_1;?> hours on course work. Looking back, did you have more or less than anticipated?</label>
                <select name="question_23">
                    <option value=""
                    <?php echo ($question_23 === '')?" selected":""; ?>>Selection Required</option> 
                    <option value="same" 
                    <?php echo ($question_23 === 'same')?" selected":""; ?>>Same</option> 
                    <option value="more" 
                    <?php echo ($question_23 === 'more')?" selected":""; ?>>More</option>
                    <option value="less" 
                    <?php echo ($question_23 === 'less')?" selected":""; ?>>Less</option>
                </select><label class="error"><?php echo $error_question_23; ?></label>
				<div class="sub_question">
					<label> If you spent more or less time on the above, please specify how many hours in total were spent:
						<input type="text" class="textfield" name="question_23_sub_1" placeholder="Hours Total" value="<?php echo $question_23_sub_1; ?>" /></label>
                        <div class="error"><?php echo $error_question_23_sub_1; ?></div>
                </div>
            </div>	

			<!--  QUESTION 24 -->
			<div class="question">
                <label><span class="question_number">5.</span> At the beginning of the experiment, you reported that you anticipated spending 
                <?php echo $question_7_sub_2;?> hours on your job. Looking back, did you have more or less than anticipated?</label>
                <select name="question_24">
                    <option value=""
                    <?php echo ($question_24 === '')?" selected":""; ?>>Selection Required</option> 
                    <option value="same" 
                    <?php echo ($question_24 === 'same')?" selected":""; ?>>Same</option> 
                    <option value="more" 
                    <?php echo ($question_24 === 'more')?" selected":""; ?>>More</option>
                    <option value="less" 
                    <?php echo ($question_24 === 'less')?" selected":""; ?>>Less</option>
                </select><label class="error"><?php echo $error_question_24; ?></label>
				<div class="sub_question">
					<label> If you spent more or less time on the above, please specify how many hours in total were spent:
						<input type="text" class="textfield" name="question_24_sub_1" placeholder="Hours Total" value="<?php echo $question_24_sub_1; ?>" /></label>
                        <div class="error"><?php echo $error_question_24_sub_1; ?></div>
                </div>
            </div>	

			<!--  QUESTION 25 -->
			<div class="question">
                <label><span class="question_number">6.</span> At the beginning of the experiment, you reported that you anticipated spending 
                <?php echo $question_7_sub_3;?> hours on social / recreational activities. Looking back, did you have more or less than anticipated?</label>
                <select name="question_25">
                    <option value=""
                    <?php echo ($question_25 === '')?" selected":""; ?>>Selection Required</option> 
                    <option value="same" 
                    <?php echo ($question_25 === 'same')?" selected":""; ?>>Same</option> 
                    <option value="more" 
                    <?php echo ($question_25 === 'more')?" selected":""; ?>>More</option>
                    <option value="less" 
                    <?php echo ($question_25 === 'less')?" selected":""; ?>>Less</option>
                </select><label class="error"><?php echo $error_question_25; ?></label>
				<div class="sub_question">
					<label> If you spent more or less time on the above, please specify how many hours in total were spent:
						<input type="text" class="textfield" name="question_25_sub_1" placeholder="Hours Total" value="<?php echo $question_25_sub_1; ?>" /></label>
                        <div class="error"><?php echo $error_question_25_sub_1; ?></div>
                </div>
            </div>	

			<!--  QUESTION 26 -->
			<div class="question">
                <label><span class="question_number">7.</span> At the beginning of the experiment, you reported that you anticipated spending 
                <?php echo $question_7_sub_4; ?> hours on family obligations. Looking back, did you have more or less than anticipated?</label>
                <select name="question_26">
                    <option value=""
                    <?php echo ($question_26 === '')?" selected":""; ?>>Selection Required</option> 
                    <option value="same" 
                    <?php echo ($question_26 === 'same')?" selected":""; ?>>Same</option> 
                    <option value="more" 
                    <?php echo ($question_26 === 'more')?" selected":""; ?>>More</option>
                    <option value="less" 
                    <?php echo ($question_26 === 'less')?" selected":""; ?>>Less</option>
                </select><label class="error"><?php echo $error_question_26; ?></label>
				<div class="sub_question">
					<label> If you spent more or less time on the above, please specify how many hours in total were spent:
						<input type="text" class="textfield" name="question_26_sub_1" placeholder="Hours Total" value="<?php echo $question_26_sub_1; ?>" /></label>
                        <div class="error"><?php echo $error_question_26_sub_1; ?></div>
                </div>
            </div>	

			<!--  QUESTION 27 -->
			<div class="question">
                <label><span class="question_number">8</span> How much time did you spend on the task (in hours)?
                        <input type="text" class="textfield" name="question_27" placeholder="Hours Total" value="<?php echo $question_27; ?>" />
                </label>
                <div class="error"><?php echo $error_question_27; ?></div>
            </div>	

			<!--  QUESTION 28 -->
			<div class="question">
                <label class="question">
                    <span class="question_number">9.</span> Please describe the process you used in order to carry out the tasks.
                </label>
				<textarea placeholder="Describe your strategy" cols="40" rows="2" name="question_28"><?php 
					if(!empty($question_28)){
						echo $question_28;
					}?></textarea>
				<label class="error"><?php echo $error_question_28; ?></label>
			</div>
			
			<!--  QUESTION 29 -->
			<div class="question">
                <label class="question">
                    <span class="question_number">10</span> Please list any unexpected events that came up and an estimate of the time you spent tending to these events.
                     If applicable, describing the events in a list formatted as follows: event, time spent, and the date.
                </label>
				<textarea placeholder="Event Description, time (hours), date" cols="40" rows="2" name="question_29"><?php 
					if(!empty($question_29)){
						echo $question_29;
					}?></textarea>
				<label class="error"><?php echo $error_question_29; ?></label>
			</div>
				 
				<input type="submit" name="submit" value="Submit Survey" class="submit_button"/> 
			</form>
        </div>	
    <div class="footer"></div>
</body> 
</html> 
