<?php

	//deleteStorage.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$storageToDelete = $_GET['sid'];
	
	$sql = "DELETE FROM storage WHERE stor_id='$storageToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: storage.php" );
	die();
?>