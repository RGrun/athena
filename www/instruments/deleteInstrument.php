<?php

	//deleteInstrument.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$instrumentToDelete = $_GET['iid'];
	
	$sql = "DELETE FROM instruments WHERE inst_id='$instrumentToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: instruments.php" );
	die();
?>