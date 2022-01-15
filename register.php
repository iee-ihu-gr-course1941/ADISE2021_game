<!DOCTYPE html>

<?php
	
	include 'register/registerManager.php';
	
?>
<html>
	<head>
		<title>Register</title>
		<link rel = "stylesheet" href= "styles/loginStyle.css">
	</head>
	
	<body>
		<div id = "container">
			<h1>Enter username and password</h1>
			<form action = "" method = "post">
				<table >
					<tr>
						<td><label>Username:</label></td>
						<td><input type = "text" name = "usernameR"> </input></td>
					</tr>
					<tr>
						<td><label>Password:</label></td>
						<td><input type = "password" name = "passwordR"> </input></td>
					</tr>
					<tr>
						<td colspan = "2"><input class = "btns" type = "submit" value = "Register!"></td>
					</tr>
				</table>
			</form>	
			<div id = "GoBack">
				<form action = "index.php">
					<input class = "btns"  type = "submit" value = "Go back!">
				</form>
			</div>
		</div>
	</body>
</html>