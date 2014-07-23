<?php

	//deleteTray.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$trayToDelete = $_GET['tid'];
	
	$sql = "DELETE FROM trays WHERE tray_id='$trayToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: trays.php" );
	die();
?>