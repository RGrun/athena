<?php

	//trayDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentTrayId = $_GET['tid'];
	
	$_SESSION['currentTrayId'] = $currentTrayId;
	
	$sql = "SELECT * FROM trays WHERE tray_id='$currentTrayId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h2>Tray Detail</h2>";
		
		$company = $worker->findCompany($cmp_id, "name");
		$team = $worker->findTeam($team_id, "name");
		$site = $worker->findSite($site_id, "name");
		$loanTeam = $worker->findTeam($loan_team, "name");
		
		$table = "<table>" .
		"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
		"<tr><td><em>Name</em></td><td>$name</td><td><a href='editTrayInfo.php?mtd=name'>Edit</a></td></tr>" .
		"<tr><td><em>Belongs To:</em></td><td>$company</td><td><a href='editTrayInfo.php?mtd=company'>Edit</a></td></tr>" .
		"<tr><td><em>Responsible Team:</em></td><td>$team</td><td><a href='editTrayInfo.php?mtd=team'>Edit</a></td></tr>" .
		"<tr><td><em>Current Location</em></td><td>$site</td><td><a href='editTrayInfo.php?mtd=site'>Edit</a></td></tr>" .
		"<tr><td><em>Loaned To</em></td><td>$loanTeam</td><td><a href='editTrayInfo.php?mtd=loanTeam'>Edit</a></td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td><td><a href='editTrayInfo.php?mtd=status'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>