<?php

	//addNewAssignment.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();

	if(isset($_POST['newcases'])) {
	
		extract($_POST);
		
		//datetime value not hooked up
		$sql = "INSERT INTO assigns (case_id, tray_id, usr_id, cli_id, dttm, status, cmt, kind)" .
		"VALUES ('$newcases', '$newtrays', '$newusers', '$newclients', '0000-00-00 00:00:00', '$newStatus', '$newComment', '$newKind')";
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: assignments.php" );
		die();
	}
	
	
	echo "<h2>Input new assignment data:</h2>";
	
	$caseSelector = $worker->createSelector("cases", "case_id", "case_id");
	$traySelector = $worker->createSelector("trays", "name", "tray_id");
	$userSelector = $worker->createSelector("users", "uname", "usr_id");
	$clientSelector = $worker->createSelector("clients", "uname", "cli_id");
	
	$statusSelector = "<select name='newStatus' size='1'>" .
	"<option value='pending'>Pending</option>" .
	"<option value='overdue'>Overdue</option>" .
	"<option value='complete'>Complete</option>" .
	"</select>";
	
	$kindSelector = "<select name='newKind' size='1'>" . 
	"<option value='1'>Dropoff</option>" .
	"<option value='2'>Pickup</option>" .
	"</select>";
	
	//time field not currently hooked up
	$form = "<form action='addNewAssignment.php' method='post'>" .
	"New Assignment&#39;s Case: $caseSelector <br/>" .
	"New Assignment&#39;s Tray: $traySelector <br/>" .
	"New Assignment&#39;s User: $userSelector <br />" .
	"New Assignment&#39;s Client: $clientSelector <br />" .
	"Time of new case: <input type='text' name='newTime' /> <br />" .
	"Comment: <input type='text' name='newComment' /> <br/>" . 
	"New Assignment&#39;s Status: $statusSelector <br />" .
	"Kind of assignment: $kindSelector <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>