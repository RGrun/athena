<?php

	//cases.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Cases</h2>";
	
	echo "<em><a href='addNewCase.php'>Add New Case</a></em> <br/> <br/>";
	
	echo "<p>Recent cases are displayed here.</p><p>Completed cases over one week old are not displayed. To see older information, check the logs.</p><p>If you see a pending case over one week old, contact the client responsible for the case.</p>";
	
	echo "<table>" .
	"<tr><th>Case ID</th><th>Current Team</th><th>Doctor</th><th>Procedure</th><th>Site</th><th>Status</th><th>Time</th><th>Comment</th></tr>";
	
	$sql = "SELECT * FROM cases ORDER BY dttm DESC";
	
	if($result = $worker->query($sql)) {
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			

			$timeToCheck = strtotime($dttm);
			
			//don't display completed cases more than one week old
			if((time() - $timeToCheck >= 604800) && $status == "Complete") continue;
			
			$dttm = $worker->checkTime($dttm);
			
			echo "<tr>";
			
			echo "<td>$case_id</td>";
			$team = $worker->findTeam($team_id, "name");
			echo "<td>$team</td>";
			$doctor = $worker->findDoctor($doc_id, "name");
			echo "<td>$doctor</td>";
			$procedure = $worker->findProcedure($proc_id, "name");
			echo "<td>$procedure</td>";
			$site = $worker->findSite($site_id, "name");
			echo "<td>$site</td>";
			echo "<td>$status</td>";
			echo "<td>$dttm</td>";
			echo "<td>$cmt</td>";
			echo "<td><a href='caseDetail.php?cid=$case_id'>Detail</a></td>";
			echo "<td><a href='deleteCase.php?cid=$case_id'>Delete</a></td></tr>";
			
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