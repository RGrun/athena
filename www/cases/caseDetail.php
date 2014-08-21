<?php

	//caseDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	$currentCase = $_GET['cid'];
	
	$_SESSION['currentCaseId'] = $currentCase;
	
	$sql = "SELECT * FROM cases WHERE case_id='$currentCase'";
	
	if($result = $worker->query($sql)) {
	
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
			
		echo "<h2>Case No: $case_id</h2>";
		
		$team = $worker->findTeam($team_id, "name");
		$doctor = $worker->findDoctor($doc_id, "name");
		$procedure = $worker->findProcedure($proc_id, "name");
		$site = $worker->findSite($site_id, "name");
		
		$dttm = $worker->checkTime($dttm);
	
		$table = "<table>" .
		"<tr><td><em>Current Team</em></td><td>$team</td><td><a href='editCaseInfo.php?mtd=team'>Edit</a></td></tr>" .
		"<tr><td><em>Doctor</em></td><td>$doctor</td><td><a href='editCaseInfo.php?mtd=doctor'>Edit</a></td></tr>" .
		"<tr><td><em>Procedure</em></td><td>$procedure</td><td><a href='editCaseInfo.php?mtd=procedure'>Edit</a></td></tr>" .
		"<tr><td><em>Site</em></td><td>$site</td><td><a href='editCaseInfo.php?mtd=site'>Edit</a></td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td><td><a href='editCaseInfo.php?mtd=status'>Edit</a></td></tr>" .
		"<tr><td><em>Date</em></td><td>$dttm</td><td><a href='editCaseInfo.php?mtd=dttm'>Edit</a></td></tr>" .
		"<tr><td><em>Comment</em></td><td>$cmt</td><td><a href='editCaseInfo.php?mtd=cmt'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
		echo "</div>";
				
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->timestampLegend();
	$htmlUtils->makeFooter();
?>
		
		