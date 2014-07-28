<?php

	//landing.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	//mark assignment as completed
	if(isset($_GET['complete']) && isset($_GET['aid'])) {
		
		$worker->editAssignmentDatabase("status", $_GET['aid'], "Complete");
		
	}
	
	
	$sql = "SELECT * from assigns WHERE usr_id='$userId'";
	
	if($result = $worker->query($sql)) {
	
		echo "<h2>Pending Assignments:</h2>";
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			//loop through assignments and print each one as a div
			echo $worker->makeTraysTable($row['usr_id'], $row['asgn_id']);
			
			
		}
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->makeFooter();

?>