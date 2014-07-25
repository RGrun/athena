<?php

	//landing.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	$sql = "SELECT * from assigns WHERE usr_id='$userId'";
	
	if($result = $worker->query($sql)) {
	
		echo "<table>" .
		"<tr><th>Assignment ID</th><th>Case</th><th>Tray</th><th>Assigned To</th><th>Client</th><th>Time</th><th>Status</th><th>Comment</th><th>Type</th></tr>";
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			
			echo "<tr>";
			
			echo "<td>$asgn_id</td>";
			echo "<td>$case_id</td>";
			$tray = $worker->findTray($tray_id, "name");
			echo "<td>$tray</td>";
			$user = $worker->findUser($usr_id, "uname");
			echo "<td>$user</td>";
			$client = $worker->findClient($cli_id, "uname");
			echo "<td>$client</td>";
			echo "<td>$dttm</td>";
			echo "<td>$status</td>";
			echo "<td>$cmt</td>";
			$kind = ($kind == 1) ? "Drop" : "Pickup";
			echo "<td>$kind</td>";
			echo "<td><a href='/athena/www/assignments/assignmentDetail.php?aid=$asgn_id'>Detail</a></td>";
			echo "<td><a href='/athena/www/assignments/deleteAssignment.php?aid=$asgn_id'>Delete</a></td></tr>";
			
		}
		
		echo "</table>";
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->makeFooter();

?>