<?php

	//newAssignment.php
	//This file is for automatically generating new assignments
	//when a new tray is added to the case in the $_GET var
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$currentCase = $_GET['cid'];

	if(isset($_POST['newtrays'])) {
	
		extract($_POST);
		
		$unixTimeDO = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$unixTimePU = mktime($newHour2, $newMin2, 0, $newMonth2, $newDay2, $newYear2);
		
		$doDate = date("Y-m-d H:i:s", $unixTimeDO);
		$puDate = date("Y-m-d H:i:s", $unixTimePU);
		
		if($puDate == "1999-11-30 00:00:00") $puDate = "0000-00-00 00:00:00";
		
		$sql = "INSERT INTO assigns (case_id, tray_id, do_usr, pu_usr, do_dttm, pu_dttm, status, cmt)" .
		"VALUES ('$currentCase', '$newtrays', '$newusers', '$newusers2', '$doDate', '$puDate', '$newStatus', '$newComment')";

		$worker->query($sql);
		$worker->closeConnection();
		
		//echo $sql;
		header( "Location: addTrays.php?cid=$currentCase" );
		die();
	}
	
	echo "<h2>Assign new tray to case:</h2>";
	
	$traySelector = $worker->createSelector("trays", "name", "tray_id");
	$doUserSelector = $worker->createSelector("users", "uname", "usr_id", true);
	$puUserSelector = $worker->createSelector("users", "uname", "usr_id", true, true);
	$clientSelector = $worker->createSelector("clients", "uname", "cli_id");
	
	$statusSelector = "<select name='newStatus' size='1'>" .
	"<option value='Pending'>Pending</option>" .
	"<option value='Overdue'>Overdue</option>" .
	"<option value='Complete'>Complete</option>" .
	"</select>";
	
			
	$dateTime = $worker->makeDateTimeSelect();
	$dateTime2 = $worker->makeDateTimeSelect("2");

	$form = "<form action='newAssignment.php?cid=$currentCase' method='post'>" .
	"Current Case: $currentCase <br/>" .
	"Select Tray: $traySelector <br/>" .
	"User to do Dropoff: $doUserSelector <br />" .
	"User to do Pickup: $puUserSelector <br />" .
	"<br/>Time of Dropoff: $dateTime <br />" .
	"<br/>Time of Pickup: $dateTime2 <br/>" .
	"Comment: <input type='text' name='newComment' /> <br/>" . 
	"New Assignment&#39;s Status: $statusSelector <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>