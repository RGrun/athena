<?php

	//logs.php
	//this page is the key to viewing the log tables.
	//this page is admins-only
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	$pageTitle = "<div class='pagetitle'><div class='wrapper'><span id='titleicon'>&#x1f4d6;</span><span id='title'>VIEW LOGS</span></div></div>";
	
	echo $pageTitle;
	
	$menu = 
	"<table>
			<tr><td><a href='/athena/www/logs/htraystor.php'>Tray Storage History</a></td></tr>
			<tr><td><a href='/athena/www/logs/traytrans.php'>Tray Transfer History</a></td></tr>
			<tr><td><a href='/athena/www/logs/htraycont.php'>Tray Content Changes</a></td></tr>
			<tr><td><a href='/athena/www/logs/hassigns.php'>Assignment History</a></td></tr>
			<tr><td><a href='/athena/www/logs/sevents.php'>System Events</a></td></tr>
		</table>";
		
	echo $menu;
	
	$htmlUtils->makeFooter();
	
?>