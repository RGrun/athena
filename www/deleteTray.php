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
		
		//is tray fulfilling a tray type assignment?
		$sql2 = "UPDATE case_ttyp SET tray_id='0' WHERE case_id='33' AND tray_id='$trayToDelete'";
		$worker->query($sql2);
		
		header("Location: addTrays.php?cid=$case");

	}
	
?>