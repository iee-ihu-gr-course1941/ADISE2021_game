<?php
	$cards = json_decode($_GET["card"]);
	$gameID = $_GET["gameID"];
	$HOST = "localhost";
	$username = "root";
	$password = "";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE);
	
	for ($i = 0 ; $i < count($cards) ; $i++) {
		$sql = "delete from cards where GID =".$_GET["gameID"]."
		and CardName = '".$cards[$i]."' ";
		$conn->query($sql);	
	}
	
	echo $_GET["card"];
	echo $_GET["gameID"];
	
	$conn->close();
?>