<?php

	//landing.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	if(isset($_SESSION['teamId'])) $teamId = $_SESSION['teamId'];
	else $teamId = null;
	
	echo "<h1>My Calendar</h1>";
	
	echo "<a href='/athena/www/teamCalendar.php'>View Team Calendar</a>";
	
	echo "<div class='landingview'>";
	
	
	$calendar = $worker->makeCalendar($userId, $teamId);
	
	echo $calendar;
	
	
	echo "</div>";
	
	$htmlUtils->makeFooter();

?>