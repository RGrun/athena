<?php

	//deleteCase.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$caseToDelete = $_GET['cid'];
	
	$sql = "DELETE FROM cases WHERE case_id='$caseToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: cases.php" );
	die();
?>