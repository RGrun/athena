<?php

	//admin.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$pageTitle = "<div class='pagetitle'><div class='wrapper'><span id='titleicon'>&#x26a0;</span><span id='title'>ADMIN PANEL</span></div></div>";
	
	echo $pageTitle;
	
	$menu = 
	"<ul>
			<li><a href='/athena/www/companies/companies.php'>Companies</a></li>
			<li><a href='/athena/www/storage/storage.php'>Storage Locations</a></li>
			<li><a href='/athena/www/users/users.php'>Users</a></li>
			<li><a href='/athena/www/sites/sites.php'>Sites</a></li>
			<li><a href='/athena/www/clients/clients.php'>Clients</a></li>
			<li><a href='/athena/www/teams/teams.php'>Teams</a></li>
			<li><a href='/athena/www/doctors/doctors.php'>Doctors</a></li>
			<li><a href='/athena/www/regions/regions.php'>Regions</a></li>
			<li><a href='/athena/www/instruments/instruments.php'>Instruments</a></li>
			<li><a href='/athena/www/trays/trays.php'>Trays</a></li>
			<li><a href='/athena/www/procedures/procedures.php'>Procedures</a></li>
			<li><a href='/athena/www/cases/cases.php'>Cases</a></li>
			<li><a href='/athena/www/assignments/assignments.php'>Assignments</a></li>
		</ul>";
		
	echo $menu;
	
	$htmlUtils->makeFooter();
	
?>