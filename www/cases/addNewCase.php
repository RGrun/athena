<?php

	//addNewCase.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();

	if(isset($_POST['newteams'])) {
	
		extract($_POST);
		
		$unixTime = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		
		$date = date("Y-m-d H:i:s", $unixTime);
		
		
		$sql = "INSERT INTO cases (team_id, doc_id, proc_id, site_id, status, dttm, cmt)" .
		"VALUES ('$newteams', '$newdoctors', '$newprocs', '$newsites', '$newStatus', '$date', '$newComment')";

		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: cases.php" );
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
	
	$form = "<form action='addNewCase.php' method='post'>" .
	"<table>" .
	"<tr><td>New Case&#39;s Team: </td><td>$teamSelector </td></tr>" .
	"<tr><td>New Case&#39;s Doctor: </td><td>$doctorSelector </td></tr>" .
	"<tr><td>New Case&#39;s Procedure: </td><td>$procedureSelector </td></tr>" .
	"<tr><td>New Case&#39;s Site: </td><td>$siteSelector </td></tr>" .
	"<tr><td>New Case&#39;s Status: </td><td>$statusSelector </td></tr>".
	"<br/>Time of new case: $dateTime <br />" .
	"<tr><td>Comment: </td><td><input type='text' name='newComment' /> </td></tr>" . 
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "$form";
	
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>