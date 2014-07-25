<?php

	//addNewTeam.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['added'])) {
	
		extract($_POST);
		
		$region = $worker->findRegion($newregions);
		
		$sql = "INSERT INTO teams (name, region, state, cmp_id, head_id)" .
		"VALUES ('$newName', '$region', '$newState', '$newcompany', '$newusers')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: teams.php" );
		die();
	}
	
	
	echo "<h2>Input new team data:</h2>";
	
	$companySelector = $worker->createSelector("company", "name", "cmp_id");
	$leaderSelector = $worker->createSelector("users", "uname", "usr_id");
	$regionSelector = $worker->createSelector("regions", "name", "reg_id");
	
	$form = "<form action='addNewTeam.php?added=true' method='post'>" .
	"New Team&#39;s Name: <input type='text' name='newName' /> <br/>" .
	"New Team&#39;s Region: $regionSelector <br />" .
	"New Team&#39;s State: <input type='text' name='newState' maxLength='2' /> <br />" .
	"New Team&#39;s Company: $companySelector <br />" .
	"New Team&#39;s Leader: $leaderSelector <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>