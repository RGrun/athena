<?php

	//landing.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	echo "<a href='/athena/www/trayInspector.php?mtd=dropoff'><h2>Drop off Trays</h2></a>";
	
	echo "<a href='/athena/www/trayInspector.php?mtd=pickup'><h2>Pick up Trays</h2></a>";

	
	$htmlUtils->makeFooter();

?>