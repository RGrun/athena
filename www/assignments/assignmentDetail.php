<?php

	//assignmentDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentAssignment = $_GET['aid'];
	
	$_SESSION['currentAssignmentId'] = $currentAssignment;
	
	$sql = "SELECT * FROM assigns WHERE asgn_id='$currentAssignment'";
	
	if($result = $worker->query($sql)) {
	
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
			
		echo "<h2>Assignment No: $asgn_id</h2>";
		
		$tray = $worker->findTray($tray_id, "name");
		$dropoffUser = $worker->findUser($do_usr, "uname");
		$pickupUser = $worker->findUser($pu_usr, "uname");
		if($dropoffUser == null) $dropoffUser = "Pending";
		if($pickupUser == null) $pickupUser = "Pending";
		
		$doTime = $worker->checkTime($do_dttm);
		$puTime = $worker->checkTime($pu_dttm);

	
		$table = "<table>" .
		"<tr><td><em>Case</em></td><td>$case_id</td><td><a href='editAssignmentInfo.php?mtd=case'>Edit</a></td></tr>" .
		"<tr><td><em>Tray</em></td><td>$tray</td><td><a href='editAssignmentInfo.php?mtd=tray'>Edit</a></td></tr>" .
		"<tr><td><em>Dropped off By</em></td><td>$dropoffUser</td><td><a href='editAssignmentInfo.php?mtd=dousr'>Edit</a></td></tr>" .
		"<tr><td><em>Picked up By</em></td><td>$pickupUser</td><td><a href='editAssignmentInfo.php?mtd=puusr'>Edit</a></td></tr>" .
		"<tr><td><em>Dropoff Time</em></td><td>$doTime</td><td><a href='editAssignmentInfo.php?mtd=dodttm'>Edit</a></td></tr>" .
		"<tr><td><em>Pickup Time</em></td><td>$puTime</td><td><a href='editAssignmentInfo.php?mtd=pudttm'>Edit</a></td></tr>" .
		"<tr><td><em>Comment</em></td><td>$cmt</td><td><a href='editAssignmentInfo.php?mtd=cmt'>Edit</a></td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td><td><a href='editAssignmentInfo.php?mtd=status'>Edit</a></td></tr>" .
		
		"</table>";
		
		echo "<p>$table</p>";
				
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->timestampLegend();
	$htmlUtils->makeFooter();
?>
		
		