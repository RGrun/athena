<?php

	//landing.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	$sql = "SELECT * from assigns WHERE usr_id='$userId'";
	
	if($result = $worker->query($sql)) {
	
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			echo $worker->makeTraysTable($row['usr_id'], $row['asgn_id']);
			
			
		}
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->makeFooter();

?>