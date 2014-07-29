<?php

	//assignments.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	echo "<h2>Assignments</h2>";
	
	echo "<em><a href='addNewAssignment.php'>Add New Assignment</a></em> <br/> <br/>";
	
	echo "<table>" .
	"<tr><th>Assignment ID</th><th>Case</th><th>Tray</th><th>Assigned To</th><th>Client</th><th>Time</th><th>Status</th><th>Comment</th><th>Type</th></tr>";
	
	$sql = "SELECT * FROM assigns";
	
	if($result = $worker->query($sql)) {
		
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
			echo "<td><a href='assignmentDetail.php?aid=$asgn_id'>Detail</a></td>";
			echo "<td><a href='deleteAssignment.php?aid=$asgn_id'>Delete</a></td></tr>";
			
		}
		
		echo "</table>";
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>