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
	
	echo "<p><a href='/athena/www/teamCalendar.php'>View Team Calendar</a></p>";
	
	echo "<p><a href='/athena/www/calendarLegend.php'>View Calendar Legend</a></p>";
	
	echo "<div class='landingview'>";
	
	
	$calendar = $worker->makeCalendar($userId, $teamId);
	
	echo $calendar;
	
	
	echo "</div>";
	
	$htmlUtils->makeFooter();

?>