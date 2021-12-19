<!DOCTYPE html>

<html>
	<head>
		<title>Game</title>
		<link rel = "stylesheet" href = "styles/gameStyle.css">
	</head>
	<script>
	
		const xmlHttp = new XMLHttpRequest();
		var PlayerName;
		function checkGames() {
			PlayerName = document.getElementById("player").innerHTML;
			xmlHttp.open("GET", "\gameControll.php?username=" + PlayerName, true);
			xmlHttp.onreadystatechange = respond;
			xmlHttp.send();
		}
		function respond() {
			if (xmlHttp.readyState == 4) {
				if (xmlHttp.status == 200) {
					var response = xmlHttp.responseText;
					var res =  document.getElementById("Player1DIV");
					res.innerHTML = "Server responded with text = " + response;
					
					if (response.substr(0,7) == "created")
						document.getElementById("name1").innerHTML = PlayerName;
					else if (response != PlayerName) {
						document.getElementById("name1").innerHTML = response;
						document.getElementById("name2").innerHTML = PlayerName;
					}
				}
				else
					alert("An error has occured with the response");
			}
		}
		
		var interval = setInterval(checkStatus,1000);
		function checkStatus() {
			
		}			
		
	</script>
	
	<body>
		<div id = "container">
			<div id = "info">
				<button type = "button" onclick = "checkGames()"> I am ready </button>
				<br>
				Info : 
				<span id = 'player'>
					<?php 
						session_start();
						echo $_SESSION['usern']; 
					?>
				</span>
				<?php
					echo "<br>player 1 :<span id = 'name1'></span> player 2:<span id = 'name2'> </span>";
				?>
			</div>
			<div id = "gamePanel">
				PLAY THE GAME
				<div id = "Player1DIV"></div>
				<div id = "Player2DIV"></div>
			</div>
		</div>
	</body>
</html>