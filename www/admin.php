<?php

	//admin.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	$pageTitle = "<div class='pagetitle'><div class='wrapper'><span id='titleicon'>&#x26a0;</span><span id='title'>ADMIN PANEL</span></div></div>";
	
	echo $pageTitle;
	
	$menu = 
	"<table>
			<tr><td><a href='/athena/www/companies/companies.php'>Companies</a></td></tr>
			<tr><td><a href='/athena/www/storage/storage.php'>Storage Locations</a></td></tr>
			<tr><td><a href='/athena/www/users/users.php'>Users</a></td></tr>
			<tr><td><a href='/athena/www/sites/sites.php'>Sites</a></td></tr>
			<tr><td><a href='/athena/www/clients/clients.php'>Clients</a></td></tr>
			<tr><td><a href='/athena/www/teams/teams.php'>Teams</a></td></tr>
			<tr><td><a href='/athena/www/doctors/doctors.php'>Doctors</a></td></tr>
			<tr><td><a href='/athena/www/regions/regions.php'>Regions</a></td></tr>
			<tr><td><a href='/athena/www/instruments/instruments.php'>Instruments</a></td></tr>
			<tr><td><a href='/athena/www/trays/trays.php'>Trays</a></td></tr>
			<tr><td><a href='/athena/www/procedures/procedures.php'>Procedures</a></td></tr>
			<tr><td><a href='/athena/www/cases/cases.php'>Cases</a></td></tr>
			<tr><td><a href='/athena/www/assignments/assignments.php'>Assignments</a></td></tr>
			<tr><td><a href='/athena/www/tags/newTags.php'>Add / Modify Tags</a></td></tr>
		</table>";
		
	echo $menu;
	
	$htmlUtils->makeFooter();
	
?>