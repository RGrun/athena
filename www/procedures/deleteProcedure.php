<?php

	//deleteProcedure.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$procedureToDelete = $_GET['pid'];
	
	$sql = "DELETE FROM procs WHERE proc_id='$procedureToDelete'";
	
	$worker->query($sql);
	
	$sql = "DELETE FROM procinsts WHERE proc_id='$procedureToDelete'";
	
	$worker->query($sql);
	
	$worker->closeConnection();
	
	header( "Location: procedures.php" );
	die();
?>