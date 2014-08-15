<?php

	//reservations.php
	
require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	//$htmlUtils->timestampLegend();
	
	$pageTitle = "<div class='pagetitle'><div class='wrapper'><span id='titleicon'>&#x1f551;</span><span id='title'>RESERVATIONS</span></div></div>";
	
	echo $pageTitle;
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	$usersTeamId = $worker->findUser($userId, "team_id");
	
	//mark case as completed
	if(isset($_GET['complete']) && isset($_GET['cid'])) {
		
		$cid = $_GET['cid'];
		
		$sql = "UPDATE cases SET status='Complete' WHERE case_id='$cid'";
		//echo $sql;
		if($worker->query($sql)) header( "Location: reservations.php" );
		
	}
	
	//mark assignment as pending
	if(isset($_GET['pending']) && isset($_GET['cid'])) {
		
		$cid = $_GET['cid'];
		
		$sql = "UPDATE cases SET status='Pending' Where case_id='$cid'";
		
		if($worker->query($sql)) header("Location: reservations.php");
	}
	
	echo "<div class='landingview'>";
	
	echo "<br/><em><a href='createNewCase.php'>Create New Case</a></em>";
	
	//display all cases
	
	//print cases tables
	
	echo "<h3>Pending Cases: </h3>";
	
	echo $htmlUtils->timestampLegend();
	
	$sql = "SELECT * FROM cases WHERE team_id='$usersTeamId' AND status='Pending'";
	$result = $worker->query($sql);
	
	while ($row = mysqli_fetch_array($result)) {
		
		$worker->makeCasesTable($userId, $row);
	
	}
	
	
	$htmlUtils->makeFooter();

?>