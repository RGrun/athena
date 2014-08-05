<?php

	//createNewCase.php
	//this script is to allow users to add new cases to the database. It's nearly identical to the admin version, though options are stripped down a bit
	//this script only allows users to add new cases to thier own team
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$currentUserId = $_SESSION['userId'];
	
	$usersTeam = $worker->findUser($currentUserId, "team_id");
	$usersTeamName = $worker->findTeam($usersTeam, "name");
	
	if(isset($_POST['newHour'])) {
	
		extract($_POST);
		
		$unixTime = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		
		$date = date("Y-m-d H:i:s", $unixTime);
		
		
		$sql = "INSERT INTO cases (team_id, doc_id, proc_id, site_id, status, dttm, cmt)" .
		"VALUES ('$usersTeam', '$newdoctors', '$newprocs', '$newsites', '$newStatus', '$date', '$newComment')";

		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: caseInspector.php" );
		die();
	}
	
	
	echo "<h2>Input new case data:</h2>";
	
	$teamSelector = $worker->createSelector("teams", "name", "team_id");
	$doctorSelector = $worker->createSelector("doctors", "name", "doc_id");
	$procedureSelector = $worker->createSelector("procs", "name", "proc_id");
	$siteSelector = $worker->createSelector("sites", "name", "site_id");
	
	$statusSelector = "<select name='newStatus' size='1'>" .
		"<option value='Pending'>Pending</option>" .
		"<option value='Complete'>Complete</option>" .
		"</select>";
		
	$dateTime = $worker->makeDateTimeSelect();
	
	$form = "<form action='createNewCase.php' method='post'>" .
	"New Case&#39;s Team: $usersTeamName <br/>" .
	"New Case&#39;s Doctor: $doctorSelector <br/>" .
	"New Case&#39;s Procedure: $procedureSelector <br />" .
	"New Case&#39;s Site: $siteSelector <br />" .
	"New Case&#39;s Status: $statusSelector <br />" .
	"<br/>Time of new case: $dateTime <br />" .
	"Comment: <input type='text' name='newComment' /> <br/>" . 
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "$form";
	
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>