<?php
	$HOST = "localhost";
	$username = "root";
	$password = "";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE);
	
	$sql = "select * from game where GameStatus = 'waiting'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$gid = $row["Gid"];
		echo "yparxoun painxidia";
	}
	else {
		//den yparxoun paixnidia ara prepei na ftiaksw ena.
		echo "den yparxoun paixnidia me anamoni";
	}
	
	
	
	
	$conn->close();
?>