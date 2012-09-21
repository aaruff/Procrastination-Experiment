<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<title>View Treatments</title> 
	<style type="text/css" media="screen"> 
			@import "../resources/js/release-datatables/media/css/site_jui.css";
			@import "../resources/js/release-datatables/media/css/demo_table_jui.css";
						@import "../resources/js/ui/css/smoothness/jquery-ui-1.8.11.custom.css";
			
			
			/*
			 * Override styles needed due to the mix of three different CSS sources! For proper examples
			 * please see the themes example in the 'Examples' section of this site
			 */
			.dataTables_info { padding-top: 0; }
			.dataTables_paginate { padding-top: 0; }
			.css_right { float: right; }
			#example_wrapper .fg-toolbar { font-size: 0.8em }
			#theme_links span { float: left; padding: 2px 10px; }
		</style>
		<script type="text/javascript" language="javascript" src="../resources/js/ui/js/jquery-1.5.1.min.js"></script> 
		<script type="text/javascript" language="javascript" src="../resources/js/release-datatables/media/js/jquery.dataTables.min.js"></script> 
		<link href='../resources/css/view_subjects.css' rel='stylesheet' type='text/css' /> 
		<script type="text/javascript" charset="utf-8"> 
		$(document).ready( function() {
			$('#subjects').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers"
			} );
		} );
		</script> 
</head> 
<body> 
<div id="parent_container">
        <div id="navigation"> 
            <ul>
                <li><a href="./createTreatment.php"><img src="../resources/img/add_treatment.png"/>New Treatment</a></li>
                <li><a href="./outputFile.php"><img src="../resources/img/add_doc.png"/>Output File</a></li> 
            </ul> 
        </div>
	
    <div id="content"> 
        <label><h2>View Treatments</h2></label>
        <div id="heading">
        </div>
        <form action="/procrastination/experimenter/manageParticipants.php" method="post"> 
            <table id="subjects"> 
            <thead>
                <tr>
                    <th>Treatment ID</th><th>Subject ID</th><th>Login</th><th>Password</th>
                    <th>Email</th><th>Survey Status</th><th>Experimenter Deadlines</th><th>Subject Deadlines Enabled</th>
                    <th>Subject Deadlines</th><th>Problem Time Restriction</th><th>Reminders Enabled</th><th>Email Delivery Time</th>
                    <th>Reminder Cost</th><th>First Task Completed</th>
                </tr>
            </thead> 
            <tbody>
                <?php foreach($subjects as $subject): ?>
                <tr>
                    <td><?php echo $subject['treatment_id'];?></td>
                    <td><?php echo $subject['id']; ?></td>
                    <td><?php echo $subject['login']; ?></td>
                    <td><?php echo $subject['password']; ?></td>
                    <td><?php echo $subject['email']?></td>
                    <td><?php echo $subject['survey_status']; ?></td>
                    <td><?php echo $subject['first_experimenter_set_deadline']; ?></td>
                    <td><?php echo $subject['subject_deadline_enabled']; ?></td>
                    <td><?php echo $subject['first_subject_set_deadline']; ?></td>
                    <td><?php echo $subject['problem_time_limit'];?></td>
                    <td><?php echo $subject['enable_reminder_notification'];?></td>
                    <td><?php echo $subject['reminder_delivery_time'];?></td>
                    <td><?php echo $subject['reminder_cost'];?></td>
                    <td><?php echo $subject['first_task_completed'];?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
            </table>
        </form> 
    </div> 
</div>
</body> 
</html> 
