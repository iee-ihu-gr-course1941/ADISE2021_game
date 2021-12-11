<!DOCTYPE html>

<html>
	<head>
		<title>Game</title>
		<link rel = "stylesheet" href = "styles/gameStyle.css">
	</head>
	<script>
		function checkGames() {
			
		}
	
	</script>
	
	<body>
		<div id = "container">
			<div id = "info">
				<button type = "button" onclick = "checkGames()"> I am ready </button>
				<br>
				Info : 
				<?php
					session_start();
					echo "<br>player 1 :".$_SESSION['usern'];
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