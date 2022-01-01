<!DOCTYPE html>

<html>
	<head>
		<title>Game</title>
		<link rel = "stylesheet" href = "styles/gameStyle.css">
	</head>
	<script src = "scripts/gameScript.js"></script>
	<body>
		<div id = "container">
			<div id = "info">
				<button type = "button" onclick = "checkGames()"> I am ready </button>
				<br><br>
				Player Name : 
				<span id = 'player'>
					<?php 
						session_start();
						echo $_SESSION['usern'];
					?>
				</span>
				<br>
				player 1 :<span id = 'name1'></span> player 2:<span id = 'name2'> </span>
			</div>
			<div id = "gamePanel"><br>
				PLAY THE GAME
				<div id = "Announcement">Please press start to begin</div>
				<div id = "Player1DIV"></div>
				<div id = "Player2DIV"></div>
			</div>
		</div>
	</body>
</html>