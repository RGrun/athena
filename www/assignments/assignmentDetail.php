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
		$user = $worker->findUser($usr_id, "uname");
		$client = $worker->findClient($cli_id, "uname");
		$kind = ($kind == 1) ? "Dropoff" : "Pickup";
	
		$table = "<table>" .
		"<tr><td><em>Case</em></td><td>$case_id</td><td><a href='editAssignmentInfo.php?mtd=case'>Edit</a></td></tr>" .
		"<tr><td><em>Tray</em></td><td>$tray</td><td><a href='editAssignmentInfo.php?mtd=tray'>Edit</a></td></tr>" .
		"<tr><td><em>Assigned To</em></td><td>$user</td><td><a href='editAssignmentInfo.php?mtd=user'>Edit</a></td></tr>" .
		"<tr><td><em>Client</em></td><td>$client</td><td><a href='editAssignmentInfo.php?mtd=client'>Edit</a></td></tr>" .
		"<tr><td><em>Date</em></td><td>$dttm</td><td><a href='editAssignmentInfo.php?mtd=dttm'>Edit</a></td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td><td><a href='editAssignmentInfo.php?mtd=status'>Edit</a></td></tr>" .
		"<tr><td><em>Comment</em></td><td>$cmt</td><td><a href='editAssignmentInfo.php?mtd=cmt'>Edit</a></td></tr>" .
		"<tr><td><em>Type</em></td><td>$kind</td><td><a href='editAssignmentInfo.php?mtd=kind'>Edit</a></td></tr>" .
		
		"</table>";
		
		echo "<p>$table</p>";
				
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
		
		