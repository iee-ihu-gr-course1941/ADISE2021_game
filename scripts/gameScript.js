const xmlHttp = new XMLHttpRequest();
const xmlHttp2 = new XMLHttpRequest();
const xmlHttp3 = new XMLHttpRequest();
var PlayerName,p1,p2;
var CheckInterval;
var checking = false;
var dispDECK = [];
var dispInd = 0;
var oppCards;
var obj;
var ann,wait , prev;


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
			ann = document.getElementById("Announcement");
			obj = JSON.parse(response); 
			p1.innerHTML = obj.Player1;
			p2.innerHTML = obj.Player2;
			if (obj.GameStatus == "waiting" && !checking) {
				CheckInterval = setInterval(checkGames,1000);
				checking = true;
			}
			if (obj.GameStatus == "started") {
				prev = 1;
				clearInterval(CheckInterval); 
				checking = false;
				ann.innerHTML = "The game has started !";
				if (p1.innerHTML == PlayerName.trim()) 
					ann.innerHTML += "Its your turn <br> <b>choose a card from opponent</b>";
				else {
					ann.innerHTML += "Wait for your turn";
					wait  = setInterval(refreshObj,1000);
				}
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
							obj.DECK.splice(i,1);
							obj.DECK.splice(j-1,1);
							i=-1;
							break;
						}
					}
				}
				
				if (p1.innerHTML == PlayerName.trim()) {
					table1 = document.getElementById("Player1DIV");
					for (var i = 0 ; i < obj.DECK.length; i++) {
						const newDiv = document.createElement("span");
						newDiv.setAttribute("class", "card");
						newDiv.setAttribute("id", obj.DECK[i]);
						newDiv.innerHTML = obj.DECK[i] + " ";
						table1.appendChild(newDiv);
					}
				}
				else {
					table1 = document.getElementById("Player2DIV");
					for (var i = 0 ; i < obj.DECK.length; i++) {
						const newDiv = document.createElement("span");
						newDiv.setAttribute("class", "card");
						newDiv.setAttribute("id", obj.DECK[i]);
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
		if (obj.GameStatus == "started" ) 
			setTimeout(getOpponentCards,2000);

	}
}


function disposeCard(card,gameID) {
	xmlHttp2.open("GET", "\DisposeCard.php?card=" + card + "&gameID=" + gameID, true);
	xmlHttp2.send();
}


function getOpponentCards() {
	if (p1.innerHTML == PlayerName.trim()) 
		var url = "\CardsNum.php?player=" + p2.innerHTML + "&gameID=" + obj.GameID;
	else
		var url = "\CardsNum.php?player=" + p1.innerHTML + "&gameID=" + obj.GameID;
	xmlHttp3.open("GET", url , true);
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

const xmlHttp4 = new XMLHttpRequest();
function playCard(event) {
	if (p1.innerHTML == PlayerName.trim() && obj.turn == '1') {
		var url = "\PlayCard.php?Player=" + p1.innerHTML + "&gameID=" + 
					+obj.GameID + "&cardN=" + event.target.id;
		xmlHttp4.open("GET", url, true);
		xmlHttp4.onreadystatechange = cardPlayedResp;
		xmlHttp4.send();
		obj.turn = 2;
		prev = 2;
		ann.innerHTML = "Wait for your turn";
		wait  = setInterval(refreshObj,1000);
	}
	if (p2.innerHTML == PlayerName.trim() && obj.turn == '2') {
		var url = "\PlayCard.php?Player=" + p2.innerHTML + "&gameID=" + 
					+obj.GameID + "&cardN=" + event.target.id;
		xmlHttp4.open("GET", url, true);
		xmlHttp4.onreadystatechange = cardPlayedResp;
		xmlHttp4.send();
		obj.turn = 1;
		prev = 1;
		ann.innerHTML = "Wait for your turn";
		wait  = setInterval(refreshObj,1000);
	}

}

function cardPlayedResp() {
	if (xmlHttp4.readyState == 4) {
		if (xmlHttp4.status == 200) {
			var card = xmlHttp4.responseText;
			//TODO : I DONT ADD THE CARD IF I DONT FIND IT !!!!!!!!!!!!!!
			console.log("Card selected = " + card);
			if (card == "KC") {
				//ADD MOUTZOURIS TO DECK AND REMOVE IT FROM OPPONENT
				console.log("You got mountzouris");
			}
			for (var i = 0 ; i < obj.DECK.length ; i++) {
				if (obj.DECK[i].length == 2)
					C1 = obj.DECK[i].substring(0,1);
				else
					C1 = obj.DECK[i].substring(0,2);
				if (card.length == 2)
					C2 = card.substring(0,1);
				else
					C2 = card.substring(0,2);
				if (C1 == C2) {
					console.log("Card desposed");
					removeCardFromTable(obj.DECK[i]);
					removeEnemyCard(i);
					disposeCard(JSON.stringify([obj.DECK[i],card]),obj.GameID);
				}
			}
		}
	}
	
}
function removeCardFromTable(card) {
	if (p1.innerHTML == PlayerName.trim()) {
		table1 = document.getElementById("Player1DIV");
		table1.removeChild(document.getElementById(card));
	}
	else if (p2.innerHTML == PlayerName.trim())  {
		table1 = document.getElementById("Player2DIV");
		table1.removeChild(document.getElementById(card));
	}
}

function removeEnemyCard(card) {
	if (p1.innerHTML == PlayerName.trim()) {
		table1 = document.getElementById("Player2DIV");
		table1.removeChild(document.getElementById(card));
	}
	else if (p2.innerHTML == PlayerName.trim()) {
		table1 = document.getElementById("Player1DIV");
		table1.removeChild(document.getElementById(card));
	}
}



const xmlHttp5 = new XMLHttpRequest();
function refreshObj() {
	console.log("Player"+ obj.turn +" is playing previous:" + prev);	
	xmlHttp5.open("GET", "\gameINFO.php?username=" + PlayerName, true);
	xmlHttp5.onreadystatechange = refResp;
	xmlHttp5.send();
}

//TODO : need to transfer the KC !!!
//ADD END OF GAME STATE !

function refResp() {
	if (xmlHttp5.readyState == 4) {
		if (xmlHttp5.status == 200) {
			var response = xmlHttp5.responseText;
			obj = JSON.parse(response);
			if (prev == 2 && obj.turn == 1) {
				ann.innerHTML = "Its your turn,choose a card from opponent";
				console.log("Turn changed from 2 to 1" + " cards = " + obj.DECK);
				table1 = document.getElementById("Player1DIV");
				var cards = document.getElementsByClassName('card');
				for (let i = 0 ; i < cards.length ; i++) 
					if (cards[i].id != obj.DECK[i])
						table1.removeChild(document.getElementById(cards[i].id));
				prev = 1;
				if (p1.innerHTML == PlayerName.trim())
					clearInterval(wait);
				table2 = document.getElementById("Player2DIV");
				table2.innerHTML = "";
				getOpponentCards();
			}
			if (prev == 1 && obj.turn == 2) {
				ann.innerHTML = "Its your turn,choose a card from opponent";
				console.log("Turn changed from 1 to 2" + " cards = " + obj.DECK);
				prev = 2;
				table1 = document.getElementById("Player2DIV");
				var cards = document.getElementsByClassName('card');
				for (let i = 0 ; i < cards.length ; i++) 
					if (cards[i].id != obj.DECK[i])
						table1.removeChild(document.getElementById(cards[i].id));
				if (p2.innerHTML == PlayerName.trim())
					clearInterval(wait);
				
				table2 = document.getElementById("Player1DIV");
				table2.innerHTML = "";
				getOpponentCards();
			}
		}
	}
}