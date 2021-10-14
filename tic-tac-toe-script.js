$(document).ready(function(){
	// initialize scores 
	var scoreX = 0;
	var scoreO = 0;
	var prevFirst = "X";
	var prevWin;
	
	// Mouse hover listener on tic-tac-toe tiles
	$(".tile").on("mouseover", function(event){
		var turn = $("#turn-tracker").text(); // Get Turn 
		var state = $(this).attr("status"); // Check tile status 
		if (state == "empty"){ // Confirm tile is empty 
			if (turn == "X"){
				$(this).addClass("preview-x"); // preview X 
			} else if (turn == "O"){
				$(this).addClass("preview-o"); // preview O 
			};
		};
	}).on("mouseout",function(event){ // Remove previews on exit hover 
		$(this).removeClass("preview-x"); 
		$(this).removeClass("preview-o");
	});
	
	// Mouse click listener on tic-tac-toe tiles 
	$(".tile").on("click", function(event){
		var turn = $("#turn-tracker").text(); // Get Turn 
		var state = $(this).attr("status"); // Check tile status 
		 if (turn == "X" && state == "empty"){ // Confirm tile is empty and X's turn 
			$(this).removeClass("preview-x");
			$(this).addClass("x");
			$(this).attr("status", "X"); // change status to "x" - used for checking winner 
			$("#turn-tracker").text("O"); // switch turn to O 
			checkGrid();
			if ($("#spMode").attr("status") == "selected"){
				$(".tile").css("pointer-events", "none"); // disable pointer events while the AI makes a turn
				setTimeout(function() {
					computerMove();
				}, 400);
				setTimeout(function() { 
					$(".tile").css("pointer-events", "auto"); //re-enable pointer events
				}, 420);
			}
		} else if (turn == "O" && state == "empty"){ // Confirm tile is empty and O's turn 
			$(this).removeClass("preview-o");
			$(this).addClass("o");
			$(this).attr("status", "O"); // change status to "o" - used for checking winner 
			$("#turn-tracker").text("X"); // switch turn to X 
			checkGrid();
		};
	});
	
	// Mouse click listener for grid reset button 
	$("#reset-button").on("click", function(event){
		$(this).css("visibility","hidden");
		$(".tile").css("pointer-events", "none"); // disable pointer events while the grid is redrawn
		$("#grid").css("animation", "erase 400ms linear forwards");
		setTimeout(function(){
			$(".tile").attr("status", "empty");
			$(".tile").attr("class", "tile");
			$("#grid").css("animation", "draw-grid 1000ms linear forwards");
			$("#grid").css("opacity", "100%");
			setTimeout(function(){
				$("#main-info").text("Turn:");
				setFirstMove(); // reenable turn tracker 
				if ($("#spMode").attr("status") == "selected" && $("#turn-tracker").text() == "O"){
					computerMove();
				}
				setTimeout(function(){
					$(".tile").css("pointer-events", "auto"); // reenable pointer events after the grid is redrawn
				}, 100);
			}, 1000);
		}, 500);
	});
	
	// Mouse hover event listener for game-mode options 
	$(".game-mode-option").on("mouseover", function(event){
		if ($(this).attr("status") == "unselected"){
			$(this).addClass("hovered");
		}
	}).on("mouseout",function(event){ // Remove previews on exit hover 
			$(this).removeClass("hovered");
	});
	
	// Mouse click event listener for game-mode options 
	$(".game-mode-option").on("click", function(event){
		$(".game-mode-option").removeClass("selected");
		$(".game-mode-option").attr("status", "unselected");
		$(this).removeClass("hovered");
		$(this).addClass("selected");
		$(this).attr("status", "selected");
		if ($(this).attr("id") == "spMode"){
			$("#player-2-name").val("Computer");
			$("#player-2-name").attr("disabled", "true");
			if ($("#turn-tracker").text() == "O"){ // Call AI when switched to Single Player mode and it is O's turn
				computerMove();
			}
		} else if ($(this).attr("id") == "tpMode"){
			$("#player-2-name").val("");
			$("#player-2-name").attr("disabled", null);
		}
	});
	
	// Mouse hover event listener for game-mode options 
	$(".first-move-option").on("mouseover", function(event){
		if ($(this).attr("status") == "unselected"){
			$(this).addClass("hovered");
		}
	}).on("mouseout",function(event){ // Remove previews on exit hover 
		$(this).removeClass("hovered");
	});
	
	// Mouse click event listener for first-move options 
	$(".first-move-option").on("click", function(event){
		$(".first-move-option").removeClass("selected");
		$(".first-move-option").attr("status", "unselected");
		$(this).removeClass("hovered");
		$(this).addClass("selected");
		$(this).attr("status", "selected");
		if ($(this).attr("id") == "xFirst"){
			//check if all tiles are empty, then hand turn over to X
			let tile1 = $("#tile1").attr("status");
			let tile2 = $("#tile2").attr("status");
			let tile3 = $("#tile3").attr("status");
			let tile4 = $("#tile4").attr("status");
			let tile5 = $("#tile5").attr("status");
			let tile6 = $("#tile6").attr("status");
			let tile7 = $("#tile7").attr("status");
			let tile8 = $("#tile8").attr("status");
			let tile9 = $("#tile9").attr("status");
			if (tile1 == "empty" && tile2 == "empty" && tile3 == "empty" && tile4 == "empty" && tile5 == "empty" && tile6 == "empty" && tile7 == "empty" && tile8 == "empty" && tile9 == "empty"){
				$("#turn-tracker").text("X");
				prevFirst = "X";
			}
		} else if ($(this).attr("id") == "oFirst"){
			//check if all tiles are empty, then hand turn over to O
			let tile1 = $("#tile1").attr("status");
			let tile2 = $("#tile2").attr("status");
			let tile3 = $("#tile3").attr("status");
			let tile4 = $("#tile4").attr("status");
			let tile5 = $("#tile5").attr("status");
			let tile6 = $("#tile6").attr("status");
			let tile7 = $("#tile7").attr("status");
			let tile8 = $("#tile8").attr("status");
			let tile9 = $("#tile9").attr("status");
			if (tile1 == "empty" && tile2 == "empty" && tile3 == "empty" && tile4 == "empty" && tile5 == "empty" && tile6 == "empty" && tile7 == "empty" && tile8 == "empty" && tile9 == "empty"){
				$("#turn-tracker").text("O");
				prevFirst = "O";
				if ($("#spMode").attr("status") == "selected"){ // Call AI when turn is given to O if playing on Single Player mode
					computerMove();
				}
			}
		}
	});
	
	// Check grid to determine whether winning conditions are met 
	function checkGrid(){
		// get status of all tiles on board 
		var tile1 = $("#tile1").attr("status");
		var tile2 = $("#tile2").attr("status");
		var tile3 = $("#tile3").attr("status");
		var tile4 = $("#tile4").attr("status");
		var tile5 = $("#tile5").attr("status");
		var tile6 = $("#tile6").attr("status");
		var tile7 = $("#tile7").attr("status");
		var tile8 = $("#tile8").attr("status");
		var tile9 = $("#tile9").attr("status");
		
		// tile 5(center tile) is in most number of possible winning combinations 
		// therefore check these win combinations when tile 5 is not empty 
		if (tile5 != "empty"){ 
			if (tile4 == tile5 && tile5 == tile6){
				let winner = tile4;
				declareWinner(winner);
				return;
			} else if (tile2 == tile5 && tile5 == tile8){
				let winner = tile2;
				declareWinner(winner);
				return;
			} else if (tile1 == tile5 && tile5 == tile9){
				let winner = tile1;
				declareWinner(winner);
				return;
			} else if (tile3 == tile5 && tile5 == tile7){
				let winner = tile3;
				declareWinner(winner);
				return;
			}
		}
		// check if tile1 is not empty 
		if (tile1 != "empty"){
			if (tile1 == tile2 && tile2 == tile3){
				let winner = tile1;
				declareWinner(winner);
				return;
			} else if (tile1 == tile4 && tile4 == tile7){
				let winner = tile1;
				declareWinner(winner);
				return;
			}
		}
		// check if tile9 is empty 
		if (tile9 != "empty"){
			if (tile7 == tile8 && tile8 == tile9){
				let winner = tile7;
				declareWinner(winner);
				return;
			} else if (tile3 == tile6 && tile6 == tile9){
				let winner = tile3;
				declareWinner(winner);
				return;
			}
		}
		// Declare draw when grid is filled and no winner is declared 
		if (tile1 != "empty" && tile2 != "empty" && tile3 != "empty" && tile4 != "empty" && tile5 != "empty" && tile6 != "empty" && tile7 != "empty" && tile8 != "empty" && tile9 != "empty"){
			$("#main-info").text("Draw");
			$("#turn-tracker").text("");
			$("#reset-button").css("visibility","visible"); // show reset button
		}
	}
	
	// Change html elements to display winner and update scoreboard
	function declareWinner(winner){
		prevWin = winner;
		$("#main-info").text(winner + " wins");
		$("#turn-tracker").text(""); // disables tracker restricting players from playing the grid 
		$("#reset-button").css("visibility","visible"); // show reset button 
		if (winner == "X"){
			scoreX += 1;
			if (scoreX % 5 == 0){ // Add 4 ticks with a strikethrough to represent 5 points 
				$("#x-fives").html($("#x-fives").html() + "<s>IIII</s> ");
				$("#x-ticks").html("");
			} else { // Add ticks to represent 1 point per tick 
				$("#x-ticks").html($("#x-ticks").html() + "I");
			}
		} else if (winner == "O"){
			scoreO += 1;
			if (scoreO % 5 == 0){ // Add 4 ticks with a strikethrough to represent 5 points 
				$("#o-fives").html($("#o-fives").html() + "<s>IIII</s> ");
				$("#o-ticks").html("");
			} else { // Add ticks to represent 1 point per tick 
				$("#o-ticks").html($("#o-ticks").html() + "I");
			}
		}
	}
	
	// Determines first turn of a new game based on user option selection
	function setFirstMove(){
		if ($("#xFirst").attr("status") == "selected"){ // set first turn to X if 'Always X' is selected 
			$("#turn-tracker").text("X");
		} else if ($("#oFirst").attr("status") == "selected"){ // set first turn to O if 'Always O' is selected 
			$("#turn-tracker").text("O");
		} else if ($("#alternateFirst").attr("status") == "selected"){ // alternate first moves based on previous 
			switch (prevFirst){
				case "X": // set first move to O
					$("#turn-tracker").text("O");
					prevFirst = "O";
					break;
				case "O": // set first move to X
					$("#turn-tracker").text("X");
					prevFirst = "X";
					break;
			}
		} else if ($("#winnerFirst").attr("status") == "selected"){ // set first move according to winner 
			switch (prevWin){
				case "X": // set first move to X
					$("#turn-tracker").text("X");
					prevFirst = "X";
					break;
				case "O": // set first move to O
					$("#turn-tracker").text("O");
					prevFirst = "O";
					break;
				default: // randomly select first move
					let r = Math.round(Math.random());
					if (r == 0){
						$("#turn-tracker").text("X");
						prevFirst = "X";
					} else if (r == 1){
						$("#turn-tracker").text("O");
						prevFirst = "O";
					}
			}
		} else if ($("#loserFirst").attr("status") == "selected"){ // set first move according to loser 
			switch (prevWin){
				case "X": // set first move to O
					$("#turn-tracker").text("O");
					prevFirst = "O";
					break;
				case "O": // set first move to X
					$("#turn-tracker").text("X");
					prevFirst = "X";
					break;
				default: // randomly select first move
					let r = Math.round(Math.random());
					if (r == 0){
						$("#turn-tracker").text("X");
						prevFirst = "X";
					} else if (r == 1){
						$("#turn-tracker").text("O");
						prevFirst = "O";
					}
			}
		}
	}
	
	// Call AI for singleplayer mode
	function computerMove(){
		// Store all tile status in variables
		let tile1 = $("#tile1").attr("status");
		let tile2 = $("#tile2").attr("status");
		let tile3 = $("#tile3").attr("status");
		let tile4 = $("#tile4").attr("status");
		let tile5 = $("#tile5").attr("status");
		let tile6 = $("#tile6").attr("status");
		let tile7 = $("#tile7").attr("status");
		let tile8 = $("#tile8").attr("status");
		let tile9 = $("#tile9").attr("status");
		let gridData = [tile1, tile2, tile3, tile4, tile5, tile6, tile7, tile8, tile9]; // Store tile status in array
		// POST to server PHP file
		var getMove = function(){
			$.post("aimove.php", {
				data: gridData
				}, function(response){ // Fetch php response
					var nextTile = response;
					var turn = $("#turn-tracker").text();
					if (turn == "O" && $(nextTile).attr("status") == "empty"){ // Confirm tile is empty and O's turn
						$(nextTile).addClass("o");
						$(nextTile).attr("status", "O"); // change status to "o" - used for checking winner 
						$("#turn-tracker").text("X"); // switch turn to X 
						checkGrid();
					}
				})
			};
		getMove();
	}

	// Preload all animation frames //
	function preloadFrames(){
		// x animation frames
		new Image().src = "animations/x-draw-animation/x-draw-1.png";
		new Image().src = "animations/x-draw-animation/x-draw-2.png";
		new Image().src = "animations/x-draw-animation/x-draw-3.png";
		new Image().src = "animations/x-draw-animation/x-draw-4.png";
		new Image().src = "animations/x-draw-animation/x-draw-5.png";
		new Image().src = "animations/x-draw-animation/x-draw-6.png";
		new Image().src = "animations/x-draw-animation/x-draw-7.png";
		new Image().src = "animations/x-draw-animation/x-draw-8.png";
		new Image().src = "animations/x-draw-animation/x-draw-9.png";
		new Image().src = "animations/x-draw-animation/x-draw-10.png";
		new Image().src = "animations/x-draw-animation/x-draw-11.png";
		new Image().src = "animations/x-draw-animation/x-draw-12.png";
		new Image().src = "animations/x-draw-animation/x-draw-13.png";
		new Image().src = "animations/x-draw-animation/x-draw-14.png";
		new Image().src = "animations/x-draw-animation/x-draw-15.png";
		// o animation frames
		new Image().src = "animations/o-draw-animation/o-draw-1.png";
		new Image().src = "animations/o-draw-animation/o-draw-2.png";
		new Image().src = "animations/o-draw-animation/o-draw-3.png";
		new Image().src = "animations/o-draw-animation/o-draw-4.png";
		new Image().src = "animations/o-draw-animation/o-draw-5.png";
		new Image().src = "animations/o-draw-animation/o-draw-6.png";
		new Image().src = "animations/o-draw-animation/o-draw-7.png";
		new Image().src = "animations/o-draw-animation/o-draw-8.png";
		new Image().src = "animations/o-draw-animation/o-draw-9.png";
		new Image().src = "animations/o-draw-animation/o-draw-10.png";
		new Image().src = "animations/o-draw-animation/o-draw-11.png";
		new Image().src = "animations/o-draw-animation/o-draw-12.png";
		new Image().src = "animations/o-draw-animation/o-draw-13.png";
		new Image().src = "animations/o-draw-animation/o-draw-14.png";
		new Image().src = "animations/o-draw-animation/o-draw-15.png";
		// grid animation frames
		new Image().src = "animations/grid-draw-animation/draw-grid-f1.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f2.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f3.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f4.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f5.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f6.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f7.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f8.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f9.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f10.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f11.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f12.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f13.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f14.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f15.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f16.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f17.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f18.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f19.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f20.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f21.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f22.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f23.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f24.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f25.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f26.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f27.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f28.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f29.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f30.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f31.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f32.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f33.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f34.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f35.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f36.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f37.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f38.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f39.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f40.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f41.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f42.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f43.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f44.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f45.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f46.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f47.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f48.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f49.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f50.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f51.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f52.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f53.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f54.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f55.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f56.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f57.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f58.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f59.png";
		new Image().src = "animations/grid-draw-animation/draw-grid-f60.png";
	}

	preloadFrames();
});

