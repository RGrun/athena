<?php

	//htmlUtils.php
	
	//include_once("dbConnector.php");
	
	class htmlUtils {
	
		//function prints html header and opening <body> tag
		public function makeHeader() {
		
		session_start();
		
		//This MUST be changed before deployment
		$rt = "athenalocal";
			
			$header = <<<_END
<!DOCTYPE html>
<html>
	<head>
		<title>Athena System</title>
		<style>
			li { display: inline; }
		</style>
	</head>	
	<body>
		<h1>Welcome to Athena</h1>
		<ul>
			<li><a href='/athenalocal/companies/companies.php'>Companies Table</a></li>
			<li><a href='/athenalocal/users/users.php'>Users Table</a></li>
			<li><a href='/athenalocal/sites/sites.php'>Sites Table</a></li>
			<li><a href='/athenalocal/clients/clients.php'>Clients Table</a></li>
		</ul>
_END;
			error_reporting(E_ALL);
			echo $header;
		}
		
		//closes up the page
		public function makeFooter() {
		
			$footer = <<<_END
	</body>
</html>
_END;
			echo $footer;
		}
		
	}
	
?>