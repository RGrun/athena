<?php
	
	//deleteTeam.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$teamToDelete = $_GET['tid'];
	
	$sql = "DELETE FROM teams WHERE team_id='$teamToDelete'";
	
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: teams.php" );
	die();
?>