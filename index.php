<!DOCTYPE html>
<?php
	include 'register/registerManager.php';
?>
<html>
	<head>
		<title>Login</title>
		<link rel = "stylesheet" href= "styles/loginStyle.css">
	</head>
	
	<body>
		<div id = "container">
			<h1>Welcome to game moutzouris</h1>
			<form action = "" method = "POST">
				<table >
					<tr>
						<td><label>Username:</label></td>
						<td><input type = "text" name = "username"> </input></td>
					</tr>
					<tr>
						<td><label>Password:</label></td>
						<td><input type = "password" name = "password"> </input></td>
					</tr>
					<tr>
						<td><input class = "btns" type = "submit" value = "Login!"></td>
						<td><input class = "btns"  type = "reset"></td>
					</tr>
				</table>
			</form>	
			
			<form action = "register.php" style = "text-align:center;" method="POST">
				<input  type = "submit" value = "Register!">
			</form>
			
		</div>
	</body>

</html>