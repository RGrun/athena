<?php

	//landing.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	$usersTeamId = $worker->findUser($userId, "team_id");
	
	
	$landingDropdown = $worker->createLandingDropdown($userId);
	
	$filterForm = "<div class='filterform'>Filter table: <br/>$landingDropdown" .
	"<input id='filterbutton' value='Filter Results' onclick='trayFilter()' type='button'/></div>";
	

	
	echo $filterForm;
	
	
	//these are for debugging javascript
	//echo "<p id='js'></p>";
	//echo "<p id='js2'></p>";
	//echo "<p id='js3'></p>";
	
	echo "<div class='landingview'>";
	
	//default display is "all" view
	
	//print sites tables
	$sql = "SELECT site_id FROM trays WHERE team_id='$usersTeamId'";
	
	
	$result = $worker->query($sql);
	$alreadyPrinted = array(); 		//mechanism to prevent multiple printings of the same site_id
	while($row = mysqli_fetch_array($result)) {
		
		if(in_array($row[0], $alreadyPrinted)) continue;
		
		$worker->makeSitesTrayTables($userId, $row[0]);
		array_push($alreadyPrinted, $row[0]);
	}
	$alreadyPrinted = array();
	
	//print status tables
	$worker->makeOpenTables($usersTeamId);
	
	$worker->makeLoanedTables($usersTeamId);
	
	$worker->makeScheduledTables($usersTeamId);
	
	
	//print cases tables
	$sql = "SELECT case_id FROM cases WHERE team_id='$usersTeamId'";
	$result = $worker->query($sql);
	
	$row = mysqli_fetch_array($result);
		
	$worker->makeCasesTable($userId, $row[0]);
	
	
	echo "</div>";
	/*
	$scriptHookup = "<script>" .
	"document.getElementById('filterbutton').onclick = showOpenElements" .
	"</script>";
	
	echo $scriptHookup;
	*/
	
	$htmlUtils->makeFooter();

?>