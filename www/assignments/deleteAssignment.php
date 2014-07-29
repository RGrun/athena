<?php

	//deleteAssignment.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$assignmentToDelete = $_GET['aid'];
	
	$sql = "DELETE FROM assigns WHERE asgn_id='$assignmentToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: assignments.php" );
	die();
?>