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
	
	$userId = $_SESSION['userId'];

	if(isset($_POST['newtrays'])) {
	
		extract($_POST);
		
		$unixTimeDO = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$unixTimePU = mktime($newHour2, $newMin2, 0, $newMonth2, $newDay2, $newYear2);
		
		$doDate = date("Y-m-d H:i:s", $unixTimeDO);
		$puDate = date("Y-m-d H:i:s", $unixTimePU);
		
		if($puDate == "1999-11-30 00:00:00") $puDate = "0000-00-00 00:00:00";
		
		$sql = "INSERT INTO assigns (case_id, tray_id, do_usr, pu_usr, do_dttm, pu_dttm, status, cmt)" .
		" VALUES ('$currentCase', '$newtrays', '$newusers', '$newusers2', '$doDate', '$puDate', '$newStatus', '$newComment')";

		$worker->query($sql);
		
		//log
		//get new asgn_id
		$sql = "SELECT asgn_id FROM assigns WHERE case_id='$currentCase' AND do_dttm='$doDate' AND pu_dttm='$puDate'";
		$result = $worker->query($sql);
		$row = mysqli_fetch_array($result);
		
		$newAssignId = $row[0];
		
		$now = time();
		$now = date("Y-m-d H:i:s", $now);
		
		$sql = "INSERT INTO h_assigns (asgn_id, action, status, from_usr, to_usr, dttm)" .
		" VALUES ('$newAssignId', 'Dropoff', 'Pending', '$userId', '$newusers', '$now')";
		
		$sql2 = "INSERT INTO h_assigns (asgn_id, action, status, from_usr, to_usr, dttm)" .
		" VALUES ('$newAssignId', 'Pickup', 'Pending', '$userId', '$newusers2', '$now')";
		
		$worker->query($sql);
		$worker->query($sql2);
		
		$userName = $worker->findUser($currentUserId, "uname");
		$trayName = $worker->findtray($newtrays, "name");
		
		$teamId = $userId; //NEEDS CHANGING
		
		if($newusers == 0)
			$worker->makeNotification($teamId, $worker->_TRAY_UNASSIGNED, $worker->_TRAY, "Dropoff for $trayName is unassigned.", date("Y-m-d H:i:s", time()));   
		if($newusers2 == 0)
			$worker->makeNotification($teamId, $worker->_TRAY_UNASSIGNED, $worker->_TRAY, "Pickup for $trayName is unassigned.", date("Y-m-d H:i:s", time()));  
		
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
	
	echo "<div class='adminTable'>";

	$form = "<form action='newAssignment.php?cid=$currentCase' method='post'>" .
	"<table>" .
	"<tr><td>Current Case: </td><td>$currentCase </td></tr>" .
	"<tr><td>Select Tray: </td><td>$traySelector </td></tr>" .
	"<tr><td>User to do Dropoff: </td><td>$doUserSelector </td></tr>" .
	"<tr><td>User to do Pickup: </td><td>$puUserSelector </td></tr>" .
	"<br/>Time of Dropoff: $dateTime <br />" .
	"<br/>Time of Pickup: $dateTime2 <br/>" .
	"<tr><td>Comment: </td><td><input type='text' name='newComment' /> </td></tr>" . 
	"<tr><td>New Assignment&#39;s Status: </td><td>$statusSelector </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "$form";
	echo "</div>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>