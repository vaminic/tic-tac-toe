<?php

	$gridData = $_POST["data"];
	
	if ($gridData[4] == "empty"){
		$winMove = checkPerimeterForWin();
		$block = checkPerimeterForThreat();
		if (isset($winMove)){
			echo $winMove;
		} elseif (isset($block)){
			echo $block;
		} else {
			echo "#tile5";
		}
	} elseif ($gridData[4] == "O"){
		// look for win conditions with center tile and move to win
		$winMove = checkPerimeterForWin();
		if (isset($winMove)){
			echo $winMove;
		} elseif ($gridData[0] == "O" && $gridData[8] == "empty"){
			echo "#tile9";
		} elseif ($gridData[1] == "O" && $gridData[7] == "empty"){
			echo "#tile8";
		} elseif ($gridData[2] == "O" && $gridData[6] == "empty"){
			echo "#tile7";
		} elseif ($gridData[3] == "O" && $gridData[5] == "empty"){
			echo "#tile6";
		} elseif ($gridData[5] == "O" && $gridData[3] == "empty"){
			echo "#tile4";
		} elseif ($gridData[6] == "O" && $gridData[2] == "empty"){
			echo "#tile3";
		} elseif ($gridData[7] == "O" && $gridData[1] == "empty"){
			echo "#tile2";
		} elseif ($gridData[8] == "O" && $gridData[0] == "empty"){
			echo "#tile1";
		} else {
			$block = checkPerimeterForThreat();
			if (isset($block)){
				echo $block;
			} else {
				// Prefer Moves where a Fork can be made:
				if ($gridData[7] == "empty" && $gridData[1] == "empty"
					&& (($gridData[6] == "O" && $gridData[8] == "empty") || ($gridData[6] == "empty" && $gridData[8] == "O"))){
					echo "#tile8";
				} elseif ($gridData[5] == "empty" && $gridData[3] == "empty"
					&& (($gridData[2] == "O" && $gridData[8] == "empty") || ($gridData[2] == "empty" && $gridData[8] == "O"))){
					echo "#tile6";
				} elseif ($gridData[3] == "empty" && $gridData[5] == "empty"
					&& (($gridData[0] == "O" && $gridData[6] == "empty") || ($gridData[0] == "empty" && $gridData[6] == "O"))){
					echo "#tile4";
				} elseif ($gridData[1] == "empty" && $gridData[7] == "empty"
					&& (($gridData[0] == "O" && $gridData[2] == "empty") || ($gridData[0] == "empty" && $gridData[2] == "O"))){
					echo "#tile2";
				} elseif ($gridData[0] == "empty" 
					&& $gridData[8] == "empty"
					&& ((($gridData[1] == "O" && $gridData[2] == "empty") || ($gridData[1] == "empty" && $gridData[2] == "O")) 
					|| (($gridData[3] == "O" && $gridData[6] == "empty") || ($gridData[3] == "empty" && $gridData[6] == "O"))))
					{
					echo "#tile1";
				} elseif ($gridData[2] == "empty" 
					&& $gridData[6] == "empty"
					&& ((($gridData[1] == "O" && $gridData[0] == "empty") || ($gridData[1] == "empty" && $gridData[0] == "O")) 
					|| (($gridData[5] == "O" && $gridData[8] == "empty") || ($gridData[5] == "empty" && $gridData[8] == "O"))))
					{
					echo "#tile3";
				} elseif ($gridData[6] == "empty" 
					&& $gridData[2] == "empty"
					&& ((($gridData[7] == "O" && $gridData[8] == "empty") || ($gridData[7] == "empty" && $gridData[8] == "O")) 
					|| (($gridData[0] == "O" && $gridData[3] == "empty") || ($gridData[0] == "empty" && $gridData[3] == "O"))))
					{
					echo "#tile3";
				} elseif ($gridData[8] == "empty" 
					&& $gridData[0] == "empty"
					&& ((($gridData[6] == "O" && $gridData[7] == "empty") || ($gridData[6] == "empty" && $gridData[7] == "O")) 
					|| (($gridData[2] == "O" && $gridData[5] == "empty") || ($gridData[2] == "empty" && $gridData[5] == "O"))))
					{
					echo "#tile3";
				}elseif ($gridData[0] == "empty" 
					&& (($gridData[1] == "O" && $gridData[2] == "empty") || ($gridData[1] == "empty" && $gridData[2] == "O")) 
					&& (($gridData[3] == "O" && $gridData[6] == "empty") || ($gridData[3] == "empty" && $gridData[6] == "O")))
					{
					echo "#tile1";
				} elseif ($gridData[2] == "empty" 
					&& (($gridData[1] == "O" && $gridData[0] == "empty") || ($gridData[1] == "empty" && $gridData[0] == "O")) 
					&& (($gridData[5] == "O" && $gridData[8] == "empty") || ($gridData[5] == "empty" && $gridData[8] == "O")))
					{
					echo "#tile3";
				} elseif ($gridData[6] == "empty" 
					&& (($gridData[7] == "O" && $gridData[8] == "empty") || ($gridData[7] == "empty" && $gridData[8] == "O")) 
					&& (($gridData[0] == "O" && $gridData[3] == "empty") || ($gridData[0] == "empty" && $gridData[3] == "O")))
					{
					echo "#tile7";
				} elseif ($gridData[8] == "empty" 
					&& (($gridData[6] == "O" && $gridData[7] == "empty") || ($gridData[6] == "empty" && $gridData[7] == "O")) 
					&& (($gridData[2] == "O" && $gridData[5] == "empty") || ($gridData[2] == "empty" && $gridData[5] == "O")))
					{
					echo "#tile9";
				// Moves with no fork but create potential winning scenarios:
				} elseif ($gridData[0] == "empty" 
					&& (($gridData[1] == "O" && $gridData[2] == "empty") 
					|| ($gridData[1] == "empty" && $gridData[2] == "O")
					|| ($gridData[3] == "O" && $gridData[6] == "empty")
					|| ($gridData[3] == "empty" && $gridData[6] == "O")
					|| $gridData[8] == "empty"))
					{
					echo "#tile1";
				} elseif ($gridData[2] == "empty" 
					&& (($gridData[1] == "O" && $gridData[0] == "empty")
					|| ($gridData[1] == "empty" && $gridData[0] == "O")
					|| ($gridData[5] == "O" && $gridData[8] == "empty")
					|| ($gridData[5] == "empty" && $gridData[8] == "O")
					|| $gridData[6] == "empty"))
					{
					echo "#tile3";
				} elseif ($gridData[6] == "empty" 
					&& (($gridData[7] == "O" && $gridData[8] == "empty") 
					|| ($gridData[7] == "empty" && $gridData[8] == "O")
					|| ($gridData[0] == "O" && $gridData[3] == "empty") 
					|| ($gridData[0] == "empty" && $gridData[3] == "O")
					|| $gridData[2] == "empty"))
					{
					echo "#tile7";
				} elseif ($gridData[8] == "empty" 
					&& (($gridData[6] == "O" && $gridData[7] == "empty")
					|| ($gridData[6] == "empty" && $gridData[7] == "O")
					|| ($gridData[2] == "O" && $gridData[5] == "empty")
					|| ($gridData[2] == "empty" && $gridData[5] == "O")
					|| $gridData[0] == "empty"))
					{
					echo "#tile9";
				//Prioritize Corners
				} elseif ($gridData[0] == "empty" 
					&& (($gridData[1] == "empty" && $gridData[2] == "empty") 
					|| ($gridData[1] == "empty" && $gridData[2] == "empty")))
					{
					echo "#tile1";
				} elseif ($gridData[2] == "empty" 
					&& (($gridData[1] == "empty" && $gridData[0] == "empty")
					|| ($gridData[1] == "empty" && $gridData[0] == "empty")))
					{
					echo "#tile3";
				} elseif ($gridData[6] == "empty" 
					&& (($gridData[7] == "empty" && $gridData[8] == "empty") 
					|| ($gridData[7] == "empty" && $gridData[8] == "empty")))
					{
					echo "#tile7";
				} elseif ($gridData[8] == "empty" 
					&& (($gridData[6] == "empty" && $gridData[7] == "empty")
					|| ($gridData[6] == "empty" && $gridData[7] == "empty")))
					{
					echo "#tile9";
				} elseif ($gridData[7] == "empty" && $gridData[1] == "empty"){
					echo "#tile8";
				} elseif ($gridData[5] == "empty" && $gridData[3] == "empty"){
					echo "#tile6";
				} else {
					// Random move:
					if ($gridData[8] == "empty"){
						echo "#tile9";
					} elseif ($gridData[7] == "empty"){
						echo "#tile8";
					} elseif ($gridData[6] == "empty"){
						echo "#tile7";
					} elseif ($gridData[5] == "empty"){
						echo "#tile6";
					} elseif ($gridData[4] == "empty"){
						echo "#tile5";
					} elseif ($gridData[3] == "empty"){
						echo "#tile4";
					} elseif ($gridData[2] == "empty"){
						echo "#tile3";
					} elseif ($gridData[1] == "empty"){
						echo "#tile2";
					} elseif ($gridData[0] == "empty"){
						echo "#tile1";
					}
				}
			}
		}
	} elseif ($gridData[4] == "X"){
		// look for threats with X on center tile and block X from winning
		$winMove = checkPerimeterForWin();
		if (isset($winMove)){
			echo $winMove;
		} elseif ($gridData[0] == "X" && $gridData[8] == "empty"){
			echo "#tile9";
		} elseif ($gridData[1] == "X" && $gridData[7] == "empty"){
			echo "#tile8";
		} elseif ($gridData[2] == "X" && $gridData[6] == "empty"){
			echo "#tile7";
		} elseif ($gridData[3] == "X" && $gridData[5] == "empty"){
			echo "#tile6";
		} elseif ($gridData[5] == "X" && $gridData[3] == "empty"){
			echo "#tile4";
		} elseif ($gridData[6] == "X" && $gridData[2] == "empty"){
			echo "#tile3";
		} elseif ($gridData[7] == "X" && $gridData[1] == "empty"){
			echo "#tile2";
		} elseif ($gridData[8] == "X" && $gridData[0] == "empty"){
			echo "#tile1";
		}else {
			$block = checkPerimeterForThreat();
			if (isset($block)){
				echo $block;
			} else {
				// Prefer Moves where a Fork can be made:
				if ($gridData[0] == "empty" 
					&& (($gridData[1] == "O" && $gridData[2] == "empty") || ($gridData[1] == "empty" && $gridData[2] == "O")) 
					&& (($gridData[3] == "O" && $gridData[6] == "empty") || ($gridData[3] == "empty" && $gridData[6] == "O")))
					{
					echo "#tile1";
				} elseif ($gridData[2] == "empty" 
					&& (($gridData[1] == "O" && $gridData[0] == "empty") || ($gridData[1] == "empty" && $gridData[0] == "O")) 
					&& (($gridData[5] == "O" && $gridData[8] == "empty") || ($gridData[5] == "empty" && $gridData[8] == "O")))
					{
					echo "#tile3";
				} elseif ($gridData[6] == "empty" 
					&& (($gridData[7] == "O" && $gridData[8] == "empty") || ($gridData[7] == "empty" && $gridData[8] == "O")) 
					&& (($gridData[0] == "O" && $gridData[3] == "empty") || ($gridData[0] == "empty" && $gridData[3] == "O")))
					{
					echo "#tile7";
				} elseif ($gridData[8] == "empty" 
					&& (($gridData[6] == "O" && $gridData[7] == "empty") || ($gridData[6] == "empty" && $gridData[7] == "O")) 
					&& (($gridData[2] == "O" && $gridData[5] == "empty") || ($gridData[2] == "empty" && $gridData[5] == "O")))
					{
					echo "#tile9";
				// Moves with no fork but creates potential winning scenarios:
				} elseif ($gridData[0] == "empty" 
					&& (($gridData[1] == "O" && $gridData[2] == "empty") 
					|| ($gridData[1] == "empty" && $gridData[2] == "O")
					|| ($gridData[3] == "O" && $gridData[6] == "empty")
					|| ($gridData[3] == "empty" && $gridData[6] == "O")))
					{
					echo "#tile1";
				} elseif ($gridData[2] == "empty" 
					&& (($gridData[1] == "O" && $gridData[0] == "empty")
					|| ($gridData[1] == "empty" && $gridData[0] == "O")
					|| ($gridData[5] == "O" && $gridData[8] == "empty")
					|| ($gridData[5] == "empty" && $gridData[8] == "O")))
					{
					echo "#tile3";
				} elseif ($gridData[6] == "empty" 
					&& (($gridData[7] == "O" && $gridData[8] == "empty") 
					|| ($gridData[7] == "empty" && $gridData[8] == "O")
					|| ($gridData[0] == "O" && $gridData[3] == "empty") 
					|| ($gridData[0] == "empty" && $gridData[3] == "O")))
					{
					echo "#tile7";
				} elseif ($gridData[8] == "empty" 
					&& (($gridData[6] == "O" && $gridData[7] == "empty")
					|| ($gridData[6] == "empty" && $gridData[7] == "O")
					|| ($gridData[2] == "O" && $gridData[5] == "empty")
					|| ($gridData[2] == "empty" && $gridData[5] == "O")))
					{
					echo "#tile9";
				//Prioritize Corners
				} elseif ($gridData[0] == "empty" 
					&& (($gridData[1] == "empty" && $gridData[2] == "empty") 
					|| ($gridData[1] == "empty" && $gridData[2] == "empty")))
					{
					echo "#tile1";
				} elseif ($gridData[2] == "empty" 
					&& (($gridData[1] == "empty" && $gridData[0] == "empty")
					|| ($gridData[1] == "empty" && $gridData[0] == "empty")))
					{
					echo "#tile3";
				} elseif ($gridData[6] == "empty" 
					&& (($gridData[7] == "empty" && $gridData[8] == "empty") 
					|| ($gridData[7] == "empty" && $gridData[8] == "empty")))
					{
					echo "#tile7";
				} elseif ($gridData[8] == "empty" 
					&& (($gridData[6] == "empty" && $gridData[7] == "empty")
					|| ($gridData[6] == "empty" && $gridData[7] == "empty")))
					{
					echo "#tile9";
				} else {
					// Random move:
					if ($gridData[8] == "empty"){
						echo "#tile9";
					} elseif ($gridData[7] == "empty"){
						echo "#tile8";
					}elseif ($gridData[6] == "empty"){
						echo "#tile7";
					}elseif ($gridData[5] == "empty"){
						echo "#tile6";
					}elseif ($gridData[4] == "empty"){
						echo "#tile5";
					}elseif ($gridData[3] == "empty"){
						echo "#tile4";
					}elseif ($gridData[2] == "empty"){
						echo "#tile3";
					}elseif ($gridData[1] == "empty"){
						echo "#tile2";
					}elseif ($gridData[0] == "empty"){
						echo "#tile1";
					}
				}
			}
		}
	}
	
	// This function checks the perimer of the grid for possible winning moves
	function checkPerimeterForWin(){
		global $gridData;
		if ($gridData[0] == "O"){
			if ($gridData[1] == "O" && $gridData[2] == "empty"){
				return "#tile3";
			} elseif ($gridData[2] == "O" && $gridData[1] == "empty"){
				return "#tile2";
			} elseif ($gridData[3] == "O" && $gridData[6] == "empty"){
				return "#tile7";
			} elseif ($gridData[6] == "O" && $gridData[3] == "empty"){
				return "#tile4";
			} else {
				return null;
			}
		} elseif ($gridData[2] == "O"){
			if ($gridData[1] == "O" && $gridData[0] == "empty"){
				return "#tile1";
			} elseif ($gridData[5] == "O" && $gridData[8] == "empty"){
				return "#tile9";
			} elseif ($gridData[8] == "O" && $gridData[5] == "empty"){
				return "#tile6";
			} else {
				return null;
			}
		} elseif ($gridData[6] == "O"){
			if ($gridData[3] == "O" && $gridData[0] == "empty"){
				return "#tile1";
			} elseif ($gridData[7] == "O" && $gridData[8] == "empty"){
				return "#tile9";
			} elseif ($gridData[8] == "O" && $gridData[7] == "empty"){
				return "#tile8";
			} else {
				return null;
			}
		} elseif ($gridData[8] == "O"){
			if ($gridData[7] == "O" && $gridData[6] == "empty"){
				return "#tile7";
			} elseif ($gridData[5] == "O" && $gridData[2] == "empty"){
				return "#tile3";
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	// This function checks the perimer of the grid for possible threats
	function checkPerimeterForThreat(){
		global $gridData;
		if ($gridData[0] == "X"){
			if ($gridData[1] == "X" && $gridData[2] == "empty"){
				return "#tile3";
			} elseif ($gridData[2] == "X" && $gridData[1] == "empty"){
				return "#tile2";
			} elseif ($gridData[3] == "X" && $gridData[6] == "empty"){
				return "#tile7";
			} elseif ($gridData[6] == "X" && $gridData[3] == "empty"){
				return "#tile4";
			} else {
				return null;
			}
		} elseif ($gridData[2] == "X"){
			if ($gridData[1] == "X" && $gridData[0] == "empty"){
				return "#tile1";
			} elseif ($gridData[5] == "X" && $gridData[8] == "empty"){
				return "#tile9";
			} elseif ($gridData[8] == "X" && $gridData[5] == "empty"){
				return "#tile6";
			} else {
				return null;
			}
		} elseif ($gridData[6] == "X"){
			if ($gridData[3] == "X" && $gridData[0] == "empty"){
				return "#tile1";
			} elseif ($gridData[7] == "X" && $gridData[8] == "empty"){
				return "#tile9";
			} elseif ($gridData[8] == "X" && $gridData[7] == "empty"){
				return "#tile8";
			} else {
				return null;
			}
		} elseif ($gridData[8] == "X"){
			if ($gridData[7] == "X" && $gridData[6] == "empty"){
				return "#tile7";
			} elseif ($gridData[5] == "X" && $gridData[2] == "empty"){
				return "#tile3";
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
?>