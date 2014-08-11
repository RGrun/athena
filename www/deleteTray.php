<?php

	//deleteTray.php
	//this is for deleting trays from the addtrays.php page
	
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$worker = new dbWorker();
	
	//mechanism to remove trays from case
	if(isset($_GET['tid'])) {
	
		$trayToDelete = $_GET['tid'];
		$case = $_GET['cid'];
		
		$sql = "DELETE FROM assigns WHERE (case_id='$case' AND tray_id='$trayToDelete')";
		$worker->query($sql);
		header("Location: addTrays.php?cid=$case");

	}
	
?>