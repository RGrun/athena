<?php

	//addTrays.php
	
	//This page is part two of the reservation process.
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	$currentCase = $_GET['cid'];
	
	$sql = "SELECT * FROM cases WHERE case_id='$currentCase'";

	$result = $worker->query($sql);
	$row = mysqli_fetch_assoc($result);
	
	extract($row);
	
	echo "<h2>Case Details: </h2>";
	
	echo "<div class='adminTable'>";
	
	extract($_POST);
	
	$team = $worker->findTeam($team_id, "name");
	$doc = $worker->findDoctor($doc_id, "name");
	$procedure = $worker->findProcedure($proc_id, "name");
	$siteName = $worker->findSite($site_id, "name");
							
	$caseTable = "<table>" .
	"<tr><td><em>Case ID:</em></td><td>$case_id</td></tr>" .
	"<tr><td><em>Assigned Team:</em></td><td>$team</td></tr>" .
	"<tr><td><em>Doctor:</em></td><td>$doc</td></tr>" .
	"<tr><td><em>Procedure:</em></td><td>$procedure</td></tr>" .
	"<tr><td><em>Site:</em></td><td>$siteName</td></tr>" .
	"<tr><td><em>Status:</em></td><td>Pending</td></tr>" .
	"<tr><td><em>Created At:</em></td><td>$dttm</td></tr>" .
	"<tr><td><em>Comment:</em></td><td>$cmt</td></tr>" .
	"</table>";
	
	echo $caseTable;
	
	echo "</div>";
	
	//This form links to a page where you can add more trays to the case
	$form = "<form method='post' action='newAssignment.php?cid=$case_id'>" .
	"<input type='submit' value='Add new tray to case' /></form>";
	
	
	echo $form;
	
	//Trays already assigned to case are displayed here
	echo "<div id='trayview'>";

	echo "<h2>Current Trays Assigned to Case: </h2>";	
	
	$sql = "SELECT tray_id FROM assigns INNER JOIN cases ON cases.case_id=assigns.case_id " .
	"WHERE (cases.case_id='$case_id' AND assigns.case_id='$case_id')";
	
	//echo $sql;
	
	$result = $worker->query($sql);
	
	while($row = mysqli_fetch_assoc($result)) {
	
		$tray = $row['tray_id'];
	
		$sql2 = "SELECT * FROM trays WHERE tray_id='$tray'";
		
		$result2 = $worker->query($sql2);
		
		$row2 = mysqli_fetch_assoc($result2);
		
		extract($row2);
		
		echo "<div class='adminTable'>";
		
		$company = $worker->findCompany($cmp_id, "name");
		$team = $worker->findTeam($team_id, "name");
		$site = $worker->findSite($site_id, "name");
		$loanTeam = $worker->findTeam($loan_team, "name");
		$storage = $worker->findStorage($stor_id, "name");
		
		if($loanTeam == null) $loanTeam = "None";
		
		if($atnow == "usr") $status = "With user";
		if($atnow == "site") $status = "At site";
		if($atnow == "stor") $status = "In storage";
		if($atnow == "unk") $status = "Unknown";
		
		$table = "<table>" .
		"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
		"<tr><td><em>Name</em></td><td>$name</td></tr>" .
		"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
		"<tr><td><em>Responsible Team:</em></td><td>$team</td></td></tr>" .
		"<tr><td><em>Current Location</em></td><td>$site</td></tr>" .
		"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
		"<tr><td><em>Stored At: </em></td><td>$storage</td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td></tr>" .
		"<tr><td><a href='deleteTray.php?tid=$tray_id&cid=$currentCase'>Remove Tray</a></td></tt>" .
		"</table>";
		
		echo "$table";
		
		echo "</div>";
	}
	
	echo "</div>";
		
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>	