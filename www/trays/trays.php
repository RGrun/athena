<?php

	//trays.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	echo "<h2>Athena Trays</h2>";
	
	echo "<em><a href='addNewTray.php'>Add New Tray</a></em>";
	
	$sql = "SELECT * FROM trays";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Tray ID</th><th>Name</th><th>Belongs To</th><th>Team</th><th>Site</th><th>Storage Location</th><th>Loaned To</th><th>Status</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
			
			$company = $worker->findCompany($cmp_id, "name");
			$team = $worker->findTeam($team_id, "name");
			$site = $worker->findSite($site_id, "name");
			$loanTeam = $worker->findTeam($loan_team, "name");
			$storage = $worker->findStorage($stor_id, "name");
			
			if($atnow == "usr") $status = "With user";
			if($atnow == "site") $status = "At site";
			if($atnow == "stor") $status = "In storage";
			if($atnow == "unk") $status = "Unknown";
			
			if($loanTeam == null) $loanTeam = "None";
	
			$table .= ("<tr><td>$tray_id</td><td>$name</td><td>$company</td><td>$team</td><td>$site</td>" .
			"<td>$storage</td><td>$loanTeam</td><td>$status</td>" .
			"<td><a href='trayDetail.php?tid=$tray_id'>Detail</a></td><td><a href='deleteTray.php?tid=$tray_id'>Delete</a></td>");

		}
		
		$table .= "</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>