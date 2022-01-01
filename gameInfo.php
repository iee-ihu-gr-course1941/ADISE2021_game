<?php 
	$user = $_GET["player"]; //get opponent
	$gameID = $_GET["gameID"];
	$HOST = "localhost";
	$username = "root";
	$password = "";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE);
	$sql = "select count(*) as num from cards where user = '".$user."'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo $row["num"];
?>