<?php
	$HOST = "";
	$username = "root";
	$password = "147258369a";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE,null,
	"/home/student/it/2017/it175061/mysql/run/mysql.sock");
	
	if ($conn->connect_error)
		echo "error";
	else if (isset($_POST["username"]) && isset($_POST["password"])) {
		if ($_POST["username"] != "" and $_POST["password"] != "") {
			$sql = "select username,password from users where 
				username = '{$_POST["username"]}' and password ='{$_POST["password"]}'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			if ($result->num_rows >0) {
				echo "<div id = 'userCreated'>welcome mr/mrs {$row['username']} </div>";
				session_start();
				$_SESSION['usern'] = $_POST["username"];
				
				header("Location:Game.php");
				exit();
			}
			else
				echo "<div id = 'errorMess'>Wrong username or password</div>";
		}
	}
	else {
		if (isset($_POST["usernameR"]) && isset($_POST["passwordR"])) {
			if ($_POST["usernameR"] != "" and $_POST["passwordR"] != "") { 
				$sql = "select username from users where username = '{$_POST["usernameR"]}'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				if ($result->num_rows > 0) 
					echo "<div id = 'errorMess'> Username already exists </div>";
				else {
					$sql = "insert into users(username,password) values('{$_POST["usernameR"]}','{$_POST["passwordR"]}')";
					$result = $conn->query($sql);
					echo "<div id = 'userCreated'> New user created </div>";
				}
			}
		}
	}
	$conn->close();
?>