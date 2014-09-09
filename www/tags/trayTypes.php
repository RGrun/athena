<?php

	//trayTypes.php
	//this is the main control page for creating tray types and adding trays to the types
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Tray Types</h2>";
	
	echo "<em><a href='addNewTrayType.php'>Add New Tray Type</a></em> <br/> <br/>";
	
	echo "<p>This page is a list of the tray types that have been created.</p><p>Tray types are a collection of tags used to auto-assign trays to cases.</p><p>Click 'Detail' to add or modify tags in tray types.</p>";
	
	echo "<table>" .
	"<tr><th>Tray Type ID</th><th>Name</th><th>Tray</th><th>Company</th><th>Team</th></tr>";
	
	$sql = "SELECT * FROM ttyp";
	
	if($result = $worker->query($sql)) {
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			
			$company = $worker->findCompany($cmp_id, "name");
			$team = $worker->findTeam($team_id, "name");
			
			if($company == null) $company = "None";
			if($team == null) $team = "None";
			
			
			echo "<tr>";
			
			echo "<td>$ttyp_id</td>";
			echo "<td>$name</td>";
			echo "<td>$company</td>";

			echo "<td>$team</td>";

			echo "<td><a href='trayTypeDetail.php?ttyp_id=$ttyp_id'>Detail</a></td>";
			echo "<td><a href='trayTypeDelete.php?ttyp_id=$ttyp_id'>Delete</a></td></tr>";
			
		}
		
		echo "</table>";
		
		echo "</div>";
	
	
	}
	
	
	
?>