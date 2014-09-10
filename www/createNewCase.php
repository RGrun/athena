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
		
		$unixTime = $unixTimeDO = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		
		$date = date("Y-m-d H:i:s", $unixTime);
		
		
		$sql = "INSERT INTO cases (team_id, doc_id, proc_id, site_id, status, dttm, cmt)" .
		"VALUES ('$usersTeam', '$newdoctors', '$newprocs', '$newsites', '$newStatus', '$date', '$newComment')";

		$worker->query($sql);
		$worker->closeConnection();
		
		$proc = $worker->findProcedure($newprocs, "name");
		$worker->logSevent($userId, "create.case", $proc , "", ""); 
		
		header( "Location: addTrayTypes.php?noTrays=$noTrays" );
		die();
	}
	
	echo "<div class='adminTable'>";
	
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
	"<table>" .
	"<tr><td>New Case&#39;s Team: </td><td>$usersTeamName </td></tr>" .
	"<tr><td>New Case&#39;s Doctor: </td><td>$doctorSelector </td></tr>" .
	"<tr><td>New Case&#39;s Procedure: </td><td>$procedureSelector </td></tr>" .
	"<tr><td>New Case&#39;s Site: </td><td>$siteSelector </td></tr>" .
	"<tr><td>New Case&#39;s Status: </td><td>$statusSelector </td></tr>" .
	"<br/>Surgery is at: <br/> $dateTime <br />" .
	"<tr><td>Comment: </td><td><input type='text' name='newComment' /> </td></tr>" .
	"<tr><td>Number of trays needed: </td><td><input type='text' name='noTrays' size='2' maxLength='2' /> </td></tr>" .
	"</table>" .	
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "$form";
	
	echo "</div>";
	
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>