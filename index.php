<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Tic-Tac-Toe Online</title>
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, user-scalable=no">
		<link rel="stylesheet" href="styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- import jQuery -->
		<script src="tic-tac-toe-script.js"></script>
	</head>
	<body>
		<div id="banner">
			<h1>TIC-TAC-TOE</h1>
		</div>
		<div id="main">
			<div id="scoreboard">
				<h2>scores:</h2>
				<label>Player X: </label>
				<input id="player-1-name" type="text"></input><br>
				<span id="x-fives"></span><span id="x-ticks"></span><br><br>
				<label>Player O: </label>
				<input id="player-2-name" type="text" value="Computer" disabled></input><br>
				<span id="o-fives"></span><span id="o-ticks"></span><br>
			</div>
			<div id="grid-container">
				<div id="grid">
					<div class="row"> <!-- row 1 -->
						<div id="tile1" class="tile" status="empty"></div> <!-- col 1 -->
						<div id="tile2" class="tile" status="empty"></div> <!-- col 2 -->
						<div id="tile3" class="tile" status="empty"></div> <!-- col 3 -->
					</div>
					<div class="row"> <!-- row 2 -->
						<div id="tile4" class="tile" status="empty"></div> <!-- col 1 -->
						<div id="tile5" class="tile" status="empty"></div> <!-- col 2 -->
						<div id="tile6" class="tile" status="empty"></div> <!-- col 3 -->
					</div>
					<div class="row"> <!-- row 3 -->
						<div id="tile7" class="tile" status="empty"></div> <!-- col 1 -->
						<div id="tile8" class="tile" status="empty"></div> <!-- col 2 -->
						<div id="tile9" class="tile" status="empty"></div> <!-- col 3 -->
					</div>
				</div>
				<div id="infobar">
					<span id="main-info">Turn: </span>
					<span id="turn-tracker">X</span><br>
					<button id="reset-button" style="visibility: hidden;">Reset</button>
				</div>
			</div>
			<div id="settings">
				<div>
					<label><u>Game Mode</u></label><br>
					<span id="spMode" class="game-mode-option selected" status="selected">Single Player</span>
					<span id="tpMode" class="game-mode-option" status="unselected" style="margin-left: 5%">Two Players</span>
				</div>
				<div style="margin-top:5vh;">
					<label><u>First Move</u></label><br>
					<span id="xFirst" class="first-move-option selected" status="selected">Always X</span>
					<span id="oFirst" class="first-move-option" status="unselected" style="margin-left: 5%">Always O</span>
					<span id="alternateFirst" class="first-move-option" status="unselected" style="margin-left: 5%">Alternating</span>
					<span id="winnerFirst" class="first-move-option" status="unselected" style="margin-left: 5%">Winner First</span>
					<span id="loserFirst" class="first-move-option" status="unselected" style="margin-left: 5%">Loser First</span>
				</div>
			</div>
		</div>
	</body>
</html>