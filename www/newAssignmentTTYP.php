<?php

	//newAssignmentTTYP.php
	//same as newAssignment.php, but for tray type fulfillments
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$currentCase = $_GET['cid'];
	
	$userId = $_SESSION['userId'];
	
	$userCompanies = $_SESSION['userCompanies'];
	
	$ttyp_id = $_GET['ttyp_id'];
	
	if(isset($_POST['newTray'])) {
	
		extract($_POST);
		
		$unixTimeDO = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$unixTimePU = mktime($newHour2, $newMin2, 0, $newMonth2, $newDay2, $newYear2);
		
		$doDate = date("Y-m-d H:i:s", $unixTimeDO);
		$puDate = date("Y-m-d H:i:s", $unixTimePU);
		
		if($puDate == "1999-11-30 00:00:00") $puDate = "0000-00-00 00:00:00";
		
		$sql = "INSERT INTO assigns (case_id, tray_id, do_usr, pu_usr, do_dttm, pu_dttm, status, cmt)" .
		" VALUES ('$currentCase', '$newTray', '$newusers', '$newusers2', '$doDate', '$puDate', '$newStatus', '$newComment')";

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
		
		$addSql = "UPDATE case_ttyp SET tray_id='$newTray' WHERE case_id='$currentCase' AND ttyp_id='$ttyp_id'";
		
		//echo $addSql;
		
		$worker->query($sql);
		$worker->query($sql2);
		$worker->query($addSql);
		
		$trayName = $worker->findtray($newTray, "name");
		
		$teamId = 0; //NEEDS CHANGING
		
		if($newusers == 0)
			$worker->makeNotification($teamId, $worker->_TRAY_UNASSIGNED, $worker->_TRAY, "Dropoff for $trayName is unassigned.", date("Y-m-d H:i:s", time()));   
		if($newusers2 == 0)
			$worker->makeNotification($teamId, $worker->_TRAY_UNASSIGNED, $worker->_TRAY, "Pickup for $trayName is unassigned.", date("Y-m-d H:i:s", time()));  

		
		header( "Location: addTrays.php?cid=$currentCase" );
		die();
	}
	
	$ttypSelect = "<select size='1' name='newTray'>";
	//$ttypSelect .= "<option value='0'>Pending</option>"; //default option
	
	//figure out which tags will fulfill type
	$goodTags = array();
	$sql2 = "SELECT tag FROM ttyp_tag WHERE ttyp_id='$ttyp_id'";
	$result2 = $worker->query($sql2);
			
	while($row2 = mysqli_fetch_array($result2)) {
		array_push($goodTags, $row2[0]);
	}
	//print_r($goodTags);
	
			
	//filter out tags that aren't part of user's company
	$sql3 = "SELECT tag, cmp_id FROM tags";
	$result3 = $worker->query($sql3);
	while($row3 = mysqli_fetch_array($result3)) {
		//filter out tags that arent in users company 
		if((!in_array($row3[1], $userCompanies) || $row3[1] != 0)) {
				array_diff($goodTags, array($row3[0]));
			}
		}
	//print_r($goodTags);
			
	$possibleTrays = array();
	//find trays with that tag assigned
	$sql4 = "SELECT tag, tray_id FROM tray_tag";
	$result4 = $worker->query($sql4);
	while($row4 = mysqli_fetch_array($result4)) {
		if(in_array($row4[0], $goodTags)) {
			array_push($possibleTrays, $row4[1]);
			}
		}
		//print_r($possibleTrays);
		
		$alreadyPrintedTrays = array();
		//$possibleTrays is now an array that contains only tray_ids that fufill the user's company requirements
		foreach($possibleTrays as $tray) {
			if(!in_array($tray, $alreadyPrintedTrays) {
				$tName = $worker->findTray($tray, "name");
				$ttypSelect .= "<option value='$tray'>$tName</option>";
				array_push($alreadyPrintedTrays, $tray);
			}
		}
			
		$ttypSelect .= "</select>";

	echo "<h2>Assign new tray to case:</h2>";
	
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

	$form = "<form action='newAssignmentTTYP.php?cid=$currentCase&ttyp_id=$ttyp_id' method='post'>" .
	"<table>" .
	"<tr><td>Current Case: </td><td>$currentCase </td></tr>" .
	"<tr><td>Select Tray: </td><td>$ttypSelect </td></tr>" .
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