<?php

	//htmlUtils.php
	
	//include_once("dbConnector.php");
	
	class htmlUtils {
	
		//function prints html header and opening <body> tag
		public function makeHeader() {
		
		session_start();
		
			
			$header = <<<_END
<!DOCTYPE html>
<html>
	<head>
		<title>Athena System</title>
		<style>
			li { display: inline; }
			table, th, td {
				border: 1px solid black;
			}
		</style>
	</head>	
	<body>
		<h1>Welcome to Athena</h1>
		<ul>
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
		</ul>
_END;
			echo $header;
		}
		
		//closes up the page
		public function makeFooter() {
		
			$footer = <<<_END
			<a href='/athena/www/index.php'>Home</a>
	</body>
</html>
_END;
			echo $footer;
		}
		
	}
	
?>