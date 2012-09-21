<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	<link href='../resources/css/login.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<div id="content">
		<div id="login_border">
			<h2>Experimenter Login</h2>
			<form action="<?php echo $post_url; ?> " method="post">
				<table cellpadding="2">
					<tr>
						<td>
							<label class="text_label">Login</label>
							<input type="text" class="text_field" value="<?php echo $login; ?>" name="login" />
						</td>
					</tr>
					<tr><td class="error"><?php echo $login_error; ?></td></tr>
					<tr>
						<td>
							<label class="text_label">Password</label>
							<input type="password" class="text_field" value="<?php echo $password; ?>" name="password" />
						</td>
					</tr>
					<tr><td class="error"><?php echo $password_error; ?></td></tr>
					<tr>
						<td><input type="submit" name="submit" value="Log In" class="submit_button" /></td>
					</tr>
				</table>
			</form>
			<label id="error"><?php echo $general_error; ?></label>
		</div>
	</div>
</body>
</html>
