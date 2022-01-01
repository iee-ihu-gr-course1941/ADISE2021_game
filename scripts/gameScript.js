const xmlHttp = new XMLHttpRequest();
const xmlHttp2 = new XMLHttpRequest();
const xmlHttp3 = new XMLHttpRequest();
var PlayerName;
var p1;
var p2;
var interval;
var checking = false;
var dispDECK = [];
var dispInd = 0;
var oppCards;
var obj;
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
			p1 = document.getElementById("name1");
			p2 = document.getElementById("name2");
			var ann = document.getElementById("Announcement");
			obj = JSON.parse(response); 
			
			p1.innerHTML = obj.Player1;
			p2.innerHTML = obj.Player2;
			if (obj.GameStatus == "waiting" && !checking) {
				interval = setInterval(checkGames,1000);
				checking = true;
			}
			if (obj.GameStatus == "started") {
				clearInterval(interval); 
				checking = false;
				ann.innerHTML = "The game has started ! Please wait for your turn ";
				ann.innerHTML += "then choose a card";
				let C1 , C2;
				for (let i = 0 ; i < obj.DECK.length ; i++) {
					for (let j = i + 1 ; j < obj.DECK.length ; j++) {
						if (obj.DECK[i].length == 2)
							C1 = obj.DECK[i].substring(0,1);
						else
							C1 = obj.DECK[i].substring(0,2);
						if (obj.DECK[j].length == 2)
							C2 = obj.DECK[j].substring(0,1);
						else
							C2 = obj.DECK[i].substring(0,2);

						if ( C1 == C2 ) {
							dispDECK[dispInd++] = obj.DECK[i];
							dispDECK[dispInd++] = obj.DECK[j];
							console.log("SPLICED!");
							obj.DECK.splice(i,1);
							obj.DECK.splice(j-1,1);
							i=0;
							break;
						}
					}
				}
				
				if (p1.innerHTML == PlayerName.trim()) {
					table1 = document.getElementById("Player1DIV");
					for (var i = 0 ; i < obj.DECK.length; i++) {
						const newDiv = document.createElement("span");
						newDiv.setAttribute("class", "card");
						//newDiv.addEventListener("click", playCard);
						newDiv.innerHTML = obj.DECK[i] + " ";
						table1.appendChild(newDiv);
					}
				}
				else {
					table1 = document.getElementById("Player2DIV");
					for (var i = 0 ; i < obj.DECK.length; i++) {
						const newDiv = document.createElement("span");
						newDiv.setAttribute("class", "card");
						newDiv.addEventListener("click", playCard);
						newDiv.innerHTML = obj.DECK[i] + " ";
						table1.appendChild(newDiv);
					}
				}
			}
		}
		else
			alert("An error has occured with the response");
		
		//disposing pairs from Database
		disposeCard(JSON.stringify(dispDECK),obj.GameID);
		if (obj.GameStatus == "started" && p1.innerHTML == PlayerName.trim() ) 
			setTimeout(getOpponentCards,2000);
		if (obj.GameStatus == "started" && p2.innerHTML == PlayerName.trim() ) 
			setTimeout(getOpponentCards,2000);

	}
}

function playCard(event) {
	window.alert(event.target.id);
}
function disposeCard(card,gameID) {
	xmlHttp2.open("GET", "\cardPlayed.php?card=" + card + "&gameID=" + gameID, true);
	xmlHttp2.send();
}

function getOpponentCards() {
	xmlHttp3.open("GET", "\gameInfo.php?player=" + PlayerName.trim() + "&gameID=" + obj.GameID , true);
	xmlHttp3.onreadystatechange = cardsResp;
	xmlHttp3.send();
}


function cardsResp() {
	if (xmlHttp3.readyState == 4) {
		if (xmlHttp3.status == 200) {
			var res = xmlHttp3.responseText;
			oppCards = res;
			if (p1.innerHTML == PlayerName.trim()) {
				var el = document.getElementById("Player2DIV");
				for (var i = 0 ; i < parseInt(res) ; i++ ) {
					const newDiv = document.createElement("span");
					newDiv.setAttribute("class", "OpponentCard");
					newDiv.setAttribute("id", i);
					newDiv.addEventListener("click", playCard);
					el.appendChild(newDiv);
					newDiv.innerHTML = "X";
				}
			}
			else {
				var el = document.getElementById("Player1DIV");
				for (var i = 0 ; i < parseInt(res) ; i++ ) {
					const newDiv = document.createElement("span");
					newDiv.setAttribute("class", "OpponentCard");
					newDiv.setAttribute("id", i);
					newDiv.addEventListener("click", playCard);
					el.appendChild(newDiv);
					newDiv.innerHTML = "X";
				}
			}
		}
	}
}
