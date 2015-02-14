<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
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
            <h2>Email Registration</h2>
        </div>
		<form action="<?php echo $post_url; ?> " method="post">
			<table cellpadding="2">
				<tr>
                    <td>
                        <label>Enter you email address:</label>
                        <input type="text" class="textfield" placeholder="your@university.edu" value="<?php echo $email; ?>" name="email" />
                    </td>
                </tr>
                <tr>
                    <td id="error"><?php echo $email_error; ?></td>
                </tr>
				<tr>
					<td><input type="submit" class="submit_button" name="submit" value="Register Email" /></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
