<?php 
	$user = $_GET["Player"];
	$gameID = $_GET["gameID"];
	$cardN = $_GET["cardN"];
	
	$HOST = "localhost";
	$username = "root";
	$password = "";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE);

	$sql = "select * from cards where Gid = ".$gameID." and user <> '".$user."'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	for ($i = -1 ; $i < (int)$cardN - 1 ; $i++)
		$row = $result->fetch_assoc();
	echo $row["CardName"];
	
	$sql = "select * from game where user1 = '".$user."' or user2 = '".$user."'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$turn = $row["turn"];
	if ($turn == 1)
		$sql = "update game set turn = 2 where Gid = ".$gameID;
	else
		$sql = "update game set turn = 1 where Gid = ".$gameID;
	$conn->query($sql);
	$conn->close();
?>