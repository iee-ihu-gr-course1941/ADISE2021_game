<?php
	$user = $_GET["username"];
	$HOST = "localhost";
	$username = "root";
	$password = "";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE);
	
	$sql = "select * from game where user1 = '".$user."' or user2 = '".$user."'";
	$result = $conn->query($sql);
	if ($result->num_rows == 0) { 
	
		$sql = "select * from game where GameStatus = 'waiting'";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$gid = $row["Gid"];
			$user1 = $row["user1"];
			$sql = "update game set GameStatus = 'started' , user2 = '".$user."' where Gid = '".$gid."'";
			if ($conn->query($sql) === TRUE) {
				echo $user1;
			} else {
				echo "<br>Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else {
			//den yparxoun paixnidia ara prepei na ftiaksw ena.
			echo "created";
			$sql = "insert into game(user1,GameStatus,turn) values('".$user."','waiting',1)";
			$conn->query($sql);
		}
	}
	
	$conn->close();
?>