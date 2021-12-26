const xmlHttp = new XMLHttpRequest();
var PlayerName;
var interval;
var checking = false;
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
			var p1 = document.getElementById("name1");
			var p2 = document.getElementById("name2");
			var obj = JSON.parse(response); 
			p1.innerHTML = obj.Player1;
			p2.innerHTML = obj.Player2;
			if (obj.GameStatus == "waiting" && !checking) {
				interval = setInterval(checkGames,1000);
				checking = true;
			}
			if (obj.GameStatus == "started") {
				clearInterval(interval); 
				checking = false;
				document.getElementById("Announcement").innerHTML = "Game started !";
				if (p1.innerHTML == PlayerName)
					gamePlaying(p1.innerHTML,p2.innerHTML);
				else
					gamePlaying(p2.innerHTML,p1.innerHTML);
			}
		}
		else
			alert("An error has occured with the response");
	}
}

function gamePlaying(thisPlayer,OtherPlayer) {
	//window.alert(thisPlayer + " " + OtherPlayer);
}