<?php

	//deleteUser.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$userToDelete = $_GET['uid'];
	
	$sql = "DELETE FROM users WHERE usr_id='$userToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: users.php" );
	die();
?>