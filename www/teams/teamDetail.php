<?php

	//teamDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentTeamId = $_GET['tid'];
	
	$_SESSION['currentTeamId'] = $currentTeamId;
	
	$sql = "SELECT * FROM teams WHERE team_id='$currentTeamId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h2>Team Detail for $name</h2>";
		
		$company = $worker->findCompany($cmp_id, "name");
		$leader = $worker->findUser($head_id, "uname");
		
		
		$table = "<table>" .
		"<tr><td><em>Team ID</em></td><td>$team_id</td></tr>" .
		"<tr><td><em>Team Name</em></td><td>$name</td><td><a href='editTeamInfo.php?mtd=name'>Edit</a></td></tr>" .
		"<tr><td><em>Region</em></td><td>$region</td><td><a href='editTeamInfo.php?mtd=region'>Edit</a></td></tr>" .
		"<tr><td><em>State</em></td><td>$state</td><td><a href='editTeamInfo.php?mtd=state'>Edit</a></td></tr>" .
		"<tr><td><em>Company</em></td><td>$company</td><td><a href='editTeamInfo.php?mtd=company'>Edit</a></td></tr>" .
		"<tr><td><em>Leader</em></td><td>$leader</td><td><a href='editTeamInfo.php?mtd=leader'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>