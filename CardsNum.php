<?php 
	$HOST = "";
	$username = "root";
	$password = "147258369a";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE,null,
	"/home/student/it/2017/it175061/mysql/run/mysql.sock");
	$user = $_GET["player"]; //get opponent
	$gameID = $_GET["gameID"];
	
	$sql = "select count(*) as num from cards where user = '".$user."'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo $row["num"];
	$conn->close();
?>