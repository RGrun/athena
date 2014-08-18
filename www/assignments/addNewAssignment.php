<?php

	//addNewAssignment.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();

	if(isset($_POST['newcases'])) {
	
		extract($_POST);
		
		$unixTimeDO = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$unixTimePU = mktime($newHour2, $newMin2, 0, $newMonth2, $newDay2, $newYear2);
		
		$doDate = date("Y-m-d H:i:s", $unixTimeDO);
		$puDate = date("Y-m-d H:i:s", $unixTimePU);
		
		if($puDate == "1999-11-30 00:00:00") $puDate = "0000-00-00 00:00:00";
		
		$sql = "INSERT INTO assigns (case_id, tray_id, do_usr, pu_usr, do_dttm, pu_dttm, status, cmt)" .
		"VALUES ('$newcases', '$newtrays', '$newusers', '$newusers2', '$doDate', '$puDate', '$newStatus', '$newComment')";

		$worker->query($sql);
		$worker->closeConnection();
		
		//echo $sql;
		header( "Location: assignments.php" );
		die();
	}
	
	
	echo "<h2>Input new assignment data:</h2>";
	
	$caseSelector = $worker->createSelector("cases", "case_id", "case_id");
	$traySelector = $worker->createSelector("trays", "name", "tray_id");
	$doUserSelector = $worker->createSelector("users", "uname", "usr_id", true);
	$puUserSelector = $worker->createSelector("users", "uname", "usr_id", true, true);
	$clientSelector = $worker->createSelector("clients", "uname", "cli_id");
	
	$statusSelector = "<select name='newStatus' size='1'>" .
	"<option value='Pending'>Pending</option>" .
	"<option value='Overdue'>Overdue</option>" .
	"<option value='Complete'>Complete</option>" .
	"</select>";
	
	$kindSelector = "<select name='newKind' size='1'>" . 
	"<option value='1'>Dropoff</option>" .
	"<option value='2'>Pickup</option>" .
	"</select>";
	
			
	$dateTime = $worker->makeDateTimeSelect();
	$dateTime2 = $worker->makeDateTimeSelect("2");

	$form = "<form action='addNewAssignment.php' method='post'>" .
	"<table>" .
	"<tr><td>New Assignment&#39;s Case: </td><td>$caseSelector </td></tr>" .
	"<tr><td>New Assignment&#39;s Tray: </td><td>$traySelector </td></tr>" .
	"<tr><td>User to do Dropoff: </td><td>$doUserSelector </td></tr>" .
	"<tr><td>User to do Pickup: </td><td>$puUserSelector </td></tr>" .
	"<br/>Time of Dropoff: $dateTime <br />" .
	"<br/>Time of Pickup: $dateTime2 <br/>" .
	"<tr><td>Comment: </td><td><input type='text' name='newComment' /> </td></tr>" . 
	"<tr><td>New Assignment&#39;s Status: </td><td>$statusSelector </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>