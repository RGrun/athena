<?php

	//deleteSite.php
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$siteToDelete = $_GET['sid'];
	
	$sql = "DELETE FROM sites WHERE site_id='$siteToDelete'";
	
	$worker->query($sql);
	
	$worker->closeConnection();
	
	header("Location: sites.php");
	die();
?>