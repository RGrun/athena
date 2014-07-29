<?php

	//deleteRegion.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$regionToDelete = $_GET['rid'];
	
	$sql = "DELETE FROM regions WHERE reg_id='$regionToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: regions.php" );
	die();
?>