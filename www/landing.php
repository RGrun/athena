<?php

	//landing.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	$usersTeamId = $worker->findUser($userId, "team_id");
	
	
	echo "<div class='landingview'>";
	
	//display all cases
	
	//print cases tables
	$sql = "SELECT case_id FROM cases WHERE team_id='$usersTeamId'";
	$result = $worker->query($sql);
	
	$row = mysqli_fetch_array($result);
		
	$worker->makeCasesTable($userId, $row[0]);
	
	
	echo "</div>";

	
	$htmlUtils->makeFooter();

?>