<?php

	//deleteAssignment.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$assignmentToDelete = $_GET['aid'];
	
	$traySql = "SELECT tray_id FROM assigns WHERE asgn_id='$assignmentToDelete'";
	$trayResult = $worker->query($traySql);
	$trayRow = mysqli_fetch_array($trayResult);
	
	$trayToDelete = $trayRow[0];
	
	$sql2 = "UPDATE case_ttyp SET tray_id='0' WHERE case_id='33' AND tray_id='$trayToDelete'";
	
	$worker->query($sql2);
	
	$sql = "DELETE FROM assigns WHERE asgn_id='$assignmentToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: assignments.php" );
	die();
?>