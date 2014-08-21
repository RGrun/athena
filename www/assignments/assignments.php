<?php

	//assignments.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Assignments</h2>";
	
	echo "<em><a href='addNewAssignment.php'>Add New Assignment</a></em> <br/> <br/>";
	
	echo "<p>All recent assignments are displayed here.</p><p>Completed assignments over one week old are not displayed. To see older information, check the logs.</p>";
	
	echo "<table>" .
	"<tr><th>Assignment ID</th><th>Case</th><th>Tray</th><th>Dropped Off By</th><th>Picked Up By</th><th>Dropoff Time</th><th>Pickup Time</th><th>Status</th><th>Comment</th></tr>";
	
	$sql = "SELECT * FROM assigns";
	
	if($result = $worker->query($sql)) {
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			
			$DOdate = strtotime($do_dttm);
			$PUdate = strtotime($pu_dttm);
		
			//don't display completed assignments more than one week old
			//$oneWeekAgo = time() - 604800;
			if((time() - $DOdate >= 604800 || time() - $PUdate >= 604800) && $status == "Complete") continue;

			//if(time() > strtotime($timeStamp)) return "<span class='error'>$timeStamp</span>"; // < 24 hours from now
			//else if($date <= $oneDayFromNow && time() < $date) return "<span class='warning'>$timeStamp</span>";
			//else return $timeStamp;
			
			$dropoffUser = $worker->findUser($do_usr, "uname");
			$pickupUser = $worker->findUser($pu_usr, "uname");
			
			if($dropoffUser == null) $dropoffUser = "Pending";
			if($pickupUser == null) $pickupUser = "Pending";
			
			$doTime = $worker->checkTime($do_dttm);
			$puTime = $worker->checkTime($pu_dttm);
			
			
			echo "<tr>";
			
			echo "<td>$asgn_id</td>";
			echo "<td>$case_id</td>";
			$tray = $worker->findTray($tray_id, "name");
			echo "<td>$tray</td>";

			echo "<td>$dropoffUser</td>";

			echo "<td>$pickupUser</td>";
			echo "<td>$doTime</td>";
			echo "<td>$puTime</td>";
			echo "<td>$status</td>";
			echo "<td>$cmt</td>";
			echo "<td><a href='assignmentDetail.php?aid=$asgn_id'>Detail</a></td>";
			echo "<td><a href='deleteAssignment.php?aid=$asgn_id'>Delete</a></td></tr>";
			
		}
		
		echo "</table>";
		
		echo "</div>";
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->timestampLegend();
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>