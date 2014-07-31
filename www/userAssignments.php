<?php

	//userAssignments.php
	
	//THIS PAGE SHOULD BE FOR ADMINS ONLY
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	//mark assignment as completed
	if(isset($_GET['complete']) && isset($_GET['aid'])) {
		
		$aid = $_GET['aid'];
		
		$sql = "UPDATE assigns SET status='Complete' WHERE asgn_id='$aid'";
		//echo $sql;
		if($worker->query($sql)) header( "Location: userAssignments.php" );
		
	}
	
	//mark assignment as pending
	if(isset($_GET['pending']) && isset($_GET['aid'])) {
		
		$aid = $_GET['aid'];
		
		$sql = "UPDATE assigns SET status='Pending' Where asgn_id='$aid'";
		
		if($worker->query($sql)) header("Location: userAssignments.php");
	}
	
	
	$sql = "SELECT * from assigns";
	
	if($result = $worker->query($sql)) {
	
		echo "<h2>Pending Assignments:</h2>";
		
		//get assoc array and print table data
		$row = mysqli_fetch_assoc($result);
			
			//loop through assignments and print each one as a div
			echo $worker->makeAssignmentTables();
			
		
		
	}
	else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	//make completed assignments table
	$sql = "SELECT * FROM assigns";
	
	if($result = $worker->query($sql)) {
		
		echo "<h2>Completed Assignments: </h2>";
		
		$row = mysqli_fetch_assoc($result);
			
		echo $worker->makeCompletedAssignments();
			
		
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->makeFooter();
	
?>