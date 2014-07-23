<?php
	
	//teams.php

	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	echo "<h2>Athena Teams</h2>";
	
	echo "<em><a href='addNewTeam.php'>Add New Team</a></em>";
	
	$sql = "SELECT * FROM teams";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Team ID</th><th>Name</th><th>Region</th><th>State</th><th>Company</th><th>Leader</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
			
			$company = $worker->findCompany($cmp_id, "name");
			$leader = $worker->findUser($head_id, "uname");
	
			$table .= ("<tr><td>$team_id</td><td>$name</td><td>$region</td><td>$state</td>" .
			"<td>$company</td><td>$leader</td></td>" .
			"<td><a href='teamDetail.php?tid=$team_id'>Detail</a></td><td><a href='deleteTeam.php?tid=$team_id'>Delete</a></td>");

		}
		
		$table .= "</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>