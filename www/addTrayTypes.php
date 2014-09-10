<?php

	//addTrayTypes.php
	//This page is for adding or removing tray types to/from a newly-created case
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$userCompanies = $_SESSION['userCompanies'];
	$teamId = $_SESSION['teamId'];
	
	
	//check for number of tray types to be added, from POST on first run through, ??? on reset
	
	if(isset($_POST['noTrays'])) $noOfTrays = $_POST['noTrays'];
	else $noOfTrays = $_GET['noTrays'];
	
	//figure out case_id, assumes most recent case is the newest case_id
	$caseSql = "SELECT case_id FROM cases ORDER BY case_id DESC";
	$caseResult = $worker->query($caseSql);
	$caseRow = mysqli_fetch_array($caseResult);
	
	$case_id = $caseRow[0];
	
	//mechanism for adding submitted data to case_ttyp
	if(isset($_POST['added'])) {
		$postSalt = 1;
		for($i = 1; $i <= $noOfTrays; $i++) {
		
			$ttypToAdd = $_POST["ttyp" . $postSalt];
			$newComment = $_POST["newComment" . $postSalt];
			
			$sql = "INSERT INTO case_ttyp (case_id, ttyp_id, cmt) VALUES ('$case_id', '$ttypToAdd', '$newComment')";
			$worker->query($sql);
			
			$postSalt++;
		}
		//NOTIFICATION CREATION GOES HERE
	
		header("Location: reservations.php");
		die();
	
	}
	
	
	echo "<div class='landingview'>"; //open landingview 
	
	echo "<p>Select the types of the trays you need here. To modify the number of trays you need, enter a new value in the box below.</p>";
	
	$numberForm = "<div class='numberForm'>" .
	"<p>Change number of trays to be added: </p>" .
	"<form action='addTrayTypes.php' method='get'>" .
	"<input type='text' maxLength='2' name='noTrays' size='2' value='$noOfTrays' /> <br/>" .
	"<input type='submit' value='Modify' /> </form></div>";
	
	echo $numberForm;
	
	//based on number of trays needed, generate a selctor of possible tray types for each one
	
	$addTrayTypesForm = "<div class='trayTypesForm'>";
	
	//change target page?
	$addTrayTypesForm .= "<form action='addTrayTypes.php' method='post'>";
	
	$salt = 1;
	for($i = 1; $i <= $noOfTrays; $i++) {
	
		$addTrayTypesForm .= "<p>Select tray #$i's type: </p>";
		$addTrayTypesForm .= "<select name='ttyp" . $salt . "' size='1'>";
		
		//generate selector
		$sql = "SELECT * FROM ttyp";
		$result = $worker->query($sql);
		while ($row = mysqli_fetch_assoc($result)) {
		
			$ttyp_id = $row['ttyp_id'];
			$name = $row['name'];
			
			if($row['team_id'] == $teamId || in_array($row['cmp_id'], $userCompanies)) {
				$addTrayTypesForm .= "<option value='$ttyp_id'>$name</option>";
			}

		}
		
		$addTrayTypesForm .= "</select><br/><br/>";
		$addTrayTypesForm .= "Comment: <input type='text' name='newComment" . $salt . "' />";
		
		$salt++;
	}
	$addTrayTypesForm .= "<br/><input type='submit' value='Confirm' />";
	$addTrayTypesForm .= "<input type='hidden' value='1' name='added' />";
	$addTrayTypesForm .= "<input type='hidden' value='$noOfTrays' name='noTrays' />";
	$addTrayTypesForm .= "</form></div>";
	
	echo $addTrayTypesForm;
	
	
	echo "</div>"; //close landingview
	
	$htmlUtils->makeFooter();
	
?>