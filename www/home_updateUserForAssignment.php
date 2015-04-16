<?php

	# home_updateUserForAssignment.php
	# AJAX page to handle assigning new user to case
	
	include_once "includes.php";
	
	$gremlin = new Gremlin();
	
	$newUser = $_POST['newUser'];
	$assignmentID = $_POST['assignment'];
	$type = $_POST['asgnType'];
	$pageOffset = $_POST['offset'];
	
	if($type == "dropoff") {
		$sql = "UPDATE assigns SET do_usr='$newUser' WHERE asgn_id='$assignmentID'";
	} else {
		$sql = "UPDATE assigns SET pu_usr='$newUser' WHERE asgn_id='$assignmentID'";
	}
	
	mysqli_query($gremlin->connection, $sql);
	
	die();
	
	
?>