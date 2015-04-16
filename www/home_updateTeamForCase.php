<?php

	# home_updateTeamForCase.php
	
	include_once "includes.php";
	
	$gremlin = new Gremlin();
	
	$newTeam = $_POST['newTeam'];
	$caseID = $_POST['caseId'];

	$sql = "UPDATE cases SET team_id='$newTeam' WHERE case_id='$caseID'";

	mysqli_query($gremlin->connection, $sql);
	
	die();
	
?>