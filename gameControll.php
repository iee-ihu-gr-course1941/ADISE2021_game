<?php
	$user = $_GET["username"];
	$HOST = "localhost";
	$username = "root";
	$password = "";
	$DATABASE = "gamedb";
	$conn = new mysqli($HOST,$username,$password,$DATABASE);
	
	$sql = "select * from game where user1 = '".$user."' or user2 = '".$user."'";
	$result = $conn->query($sql);
	
	if ($result->num_rows == 0) { //if user not in game
		$sql = "select * from game where GameStatus = 'waiting'"; //find a game
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) { //if a game have been found
			$row = $result->fetch_assoc();
			$gid = $row["Gid"];
			$user1 = $row["user1"];
			$sql = "update game set GameStatus = 'started' , user2 = '".$user."' where Gid = '".$gid."'";
			if ($conn->query($sql) === TRUE) {
				$sql = "select * from game where user1 = '".$user."' or user2 = '".$user."'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				echo '{"turn":"'.$row["turn"].'","GameID":"'.$row["Gid"].'","Player1":"'.$row["user1"].'",
				"Player2":"'.$row["user2"].'","GameStatus":"'.$row["GameStatus"].'"';
				$conn->query("update cards set user = '".$row["user2"]."'
					where Gid = ".$row["Gid"]." and user = 'player2'");
				
				//now we pass the deck to user 2 and the game begins
				$sql = "select * from cards where user = '".$user."' and Gid = '".$row["Gid"]."'";
				$result = $conn->query($sql);
				$i = 0;
				while ($row = $result->fetch_assoc()) {
					$deck[$i] = $row["CardName"];
					$i++;
				}
				
				echo ',"DECK":'.json_encode($deck).'}';
				
			} else
				echo "<br>Error: " . $sql . "<br>" . $conn->error;
		}
		else { //if game hasn't been found we create one
			$sql = "insert into game(user1,GameStatus,turn) values('".$user."','waiting',1)";
			$conn->query($sql);
			$sql = "select * from game where user1 = '".$user."' or user2 = '".$user."'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			echo '{"turn":"'.$row["turn"].'","GameID":"'.$row["Gid"].'","Player1":"'.$row["user1"].'",
			"Player2":"'.$row["user2"].'","GameStatus":"'.$row["GameStatus"].'"}';
			
			//create a deck for this particular game. 
			$Numbers = array("1","2","3","4","5","6","7","8","9","10");
			$Suits = array("C","D","H","S"); //clubs , diamonds , hearts , spades
			$k = 0;
			for ($i=0; $i<count($Numbers) ; $i++) 
				for ($j=0; $j<count($Suits) ; $j++) 
					$deck[$k++] = $Numbers[$i].$Suits[$j];
			$deck[$k] = "KC";
			shuffle($deck);
			$N = count($deck);
			//insert the deck into the database.
			for ($i = 0 ; $i < $N - 1 ; $i = $i + 2) {
				$conn->query("insert into cards(Gid,user,CardName) 
							values(".$row["Gid"].",'".$user."','".$deck[$i]."')");
				$conn->query("insert into cards(Gid,user,CardName) 
							values(".$row["Gid"].",'player2','".$deck[$i+1]."')");
			}
			if (rand(0,100) > 50) {
				$conn->query("insert into cards(Gid,user,CardName) 
							values(".$row["Gid"].",'".$row["user1"]."','".$deck[$i]."')");
			}
			else{
				$conn->query("insert into cards(Gid,user,CardName) 
							values(".$row["Gid"].",player2,'".$deck[$i]."')");
			}
		}
	}
	else {
		$row = $result->fetch_assoc();
		echo '{"turn":"'.$row["turn"].'","GameID":"'.$row["Gid"].'","Player1":"'.$row["user1"].'",
		"Player2":"'.$row["user2"].'","GameStatus":"'.$row["GameStatus"].'"';
		$sql = "select * from cards where user = '".$user."' and Gid = '".$row["Gid"]."'";
		$result = $conn->query($sql);
		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$deck[$i] = $row["CardName"];
			$i++;
		}
		
		echo ',"DECK":'.json_encode($deck).'}';
		
	}
	
	$conn->close();
?>