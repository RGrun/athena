<?php

	//cases.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	echo "<h2>Cases</h2>";
	
	echo "<em><a href='addNewCase.php'>Add New Case</a></em> <br/> <br/>";
	
	echo "<table>" .
	"<tr><th>Case ID</th><th>Current Team</th><th>Doctor</th><th>Procedure</th><th>Site</th><th>Status</th><th>Time</th><th>Comment</th></tr>";
	
	$sql = "SELECT * FROM cases";
	
	if($result = $worker->query($sql)) {
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			
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
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->timestampLegend();
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>