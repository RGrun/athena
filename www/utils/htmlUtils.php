<?php

	//htmlUtils.php
	
	//include_once("dbConnector.php");
	
	class htmlUtils {
	
		//function prints html header and opening <body> tag
		public function makeHeader() {
		
		
		//session control
		session_start();
		
		if(isset($_SESSION['user'])) {
			$currentUser = $_SESSION['user'];
			$loggedIn = TRUE;
			$userStr = $currentUser;
		} else {
			$loggedIn = FALSE;
			$userStr = "Guest";
		}
		
			
			$header = <<<_END
<!DOCTYPE html>
<html>
	<head>
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
	</head>	
	<body>
	<div class='header'>
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
		</div>
		<div class='main'>
	
_END;

		$loginForm = "<form method='post' action='login.php'>" .
		"<span class='fieldname'>Username</span><input type='text' name='user' /><br/>".
		"<span class='fieldname'>Password</span><input type='password' name='pass' /><br/>" .
		"<input type='submit' value='Login' /> </form>";
	
		$notLoggedInHeader = <<<_END
			
			<!DOCTYPE html>
<html>
	<head>
		<title>Athena System</title>
		<style>
			li { display: inline; }
			table, th, td {
				border: 1px solid black;
				padding: 3px;
			}
		</style>
	</head>	
	<body>
		<h1>Welcome to Athena</h1>
		<div class='main'><h3>Please enter your username and password to log in</h3>
		<p>$loginForm</p>
		
_END;
			
			if($loggedIn) {
				
				echo $header;
				echo "Current User: $userStr <br/>";
				echo "<a href='/athena/www/landing.php'>Return to landing.</a><br/><br/>";
			} else {
				echo $notLoggedInHeader;
				die("<p>Please log in to Athena. <br/> <br/> <a href='login.php'>Click Here</a> to log in.</p>");
				
			}
		}
		
		//closes up the page
		public function makeFooter() {
		
			$footer = <<<_END
			
			</div>
			<div class='footer'>
			<br/><a href='/athena/www/index.php'>Home</a>
			<br/><a href='/athena/www/logout.php'>Logout</a><br/>
			</div>
	</body>
</html>
_END;
			echo $footer;
		}
		
	}
	
	
	
?>