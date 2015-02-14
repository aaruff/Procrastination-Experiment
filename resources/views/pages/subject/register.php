<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	<link href='../styles/viewAllQuestions.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<div id="heading">
		<h2>Registration</h2>
	</div>
	<div id="wrapper">
	
	<div id="navigation">
	</div>
	
	<fieldset id="content">
		<legend>Enter the Login/Password given to you by the experimenter and enter the email address that will receive our notices</legend>
		<form action="<?php echo $post_url; ?> " method="post">
			<table cellpadding="2">
				<tr><td></td><td id="error"><?php echo $general_error; ?></td></tr>
				<tr>
					<td>Login</td>
					<td><input type="text" value="<?php echo $login; ?>" name="login" /></td>
					<td id="error"><?php echo $login_error; ?></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" value="<?php echo $password; ?>" name="password" /></td>
					<td id="error"><?php echo $password_error; ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input type="text" value="<?php echo $email; ?>" name="email" /></td>
					<td id="error"><?php echo $email_error; ?></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="submit" id="submit" /></td>
					<td></td>
				</tr>
			</table>
		</form>
	</fieldset>
	</div>
</body>
</html>