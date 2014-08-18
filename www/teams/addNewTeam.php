<?php

	//addNewTeam.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['added'])) {
	
		extract($_POST);
		
		$region = $worker->findRegion($newregions, "name");
		
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
	"<table>" .
	"<tr><td>New Team&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" .
	"<tr><td>New Team&#39;s Region: </td><td>$regionSelector </td></tr>" .
	"<tr><td>New Team&#39;s State: </td><td><input type='text' name='newState' maxLength='2' /> </td></tr>" .
	"<tr><td>New Team&#39;s Company: </td><td>$companySelector </td></tr>" .
	"<tr><td>New Team&#39;s Leader: </td><td>$leaderSelector </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>