<?php

	//addNewCase.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();

	if(isset($_POST['newteams'])) {
	
		extract($_POST);
		
		//datetime value not hooked up
		$sql = "INSERT INTO cases (team_id, doc_id, proc_id, site_id, status, dttm, cmt)" .
		"VALUES ('$newteams', '$newdoctors', '$newprocs', '$newsites', '$newStatus', '0000-00-00 00:00:00', '$newComment')";

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
	//time field not currently hooked up
	$form = "<form action='addNewCase.php' method='post'>" .
	"New Case&#39;s Team: $teamSelector <br/>" .
	"New Case&#39;s Doctor: $doctorSelector <br/>" .
	"New Case&#39;s Procedure: $procedureSelector <br />" .
	"New Case&#39;s Site: $siteSelector <br />" .
	"New Case&#39;s Status: <input type='text' name='newStatus' /> <br />" .
	"Time of new case: <input type='text' name='newTime' /> <br />" .
	"Comment: <input type='text' name='newComment' /> <br/>" . 
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>