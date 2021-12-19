<?php
	$user = $_GET["username"];
	$HOST = "localhost";
	$username = "root";
	$password = "";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE);
	$sql = "select GameStatus from game where user1 = '".$user."' or user2 = '".$user."'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo $row['GameStatus'];
?>