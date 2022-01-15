<?php
	$HOST = "";
	$username = "root";
	$password = "147258369a";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE,null,
	"/home/student/it/2017/it175061/mysql/run/mysql.sock");
	$cards = json_decode($_GET["card"]);
	$gameID = $_GET["gameID"];
	
	
	for ($i = 0 ; $i < count($cards) ; $i++) {
		$sql = "delete from cards where GID =".$_GET["gameID"]."
		and CardName = '".$cards[$i]."' ";
		$conn->query($sql);	
	}

	$conn->close();
?>