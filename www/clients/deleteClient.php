<?php

	//deleteClient.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$clientToDelete = $_GET['cid'];
	
	$sql = "DELETE FROM clients WHERE cli_id='$clientToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: clients.php" );
	die();
?>