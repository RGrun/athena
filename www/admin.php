<?php

	//admin.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$menu = 
	"<ul>
			<li><a href='/athena/www/companies/companies.php'>Companies Table</a></li>
			<li><a href='/athena/www/users/users.php'>Users Table</a></li>
			<li><a href='/athena/www/sites/sites.php'>Sites Table</a></li>
			<li><a href='/athena/www/clients/clients.php'>Clients Table</a></li>
			<li><a href='/athena/www/teams/teams.php'>Teams Table</a></li>
			<li><a href='/athena/www/doctors/doctors.php'>Doctors Table</a></li>
			<li><a href='/athena/www/regions/regions.php'>Regions Table</a></li>
			<li><a href='/athena/www/instruments/instruments.php'>Instruments Table</a></li>
			<li><a href='/athena/www/trays/trays.php'>Trays Table</a></li>
			<li><a href='/athena/www/procedures/procedures.php'>Procedures Table</a></li>
			<li><a href='/athena/www/cases/cases.php'>Cases Table</a></li>
			<li><a href='/athena/www/assignments/assignments.php'>Assignments Table</a></li>
		</ul>";
		
	echo $menu;
	
	$htmlUtils->makeFooter();
	
?>