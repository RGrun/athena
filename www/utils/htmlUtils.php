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
			$currentUserId = $_SESSION['userId'];
		} else {
			$loggedIn = FALSE;
			$userStr = "Guest";
			$currentUserId = "";
		}
		
		if(isset($_GET['a'])) {
			$error = "<span class='error'>Login error, please try again</span><br/>";
		} else {
			$error = "";
		}
			
			$header = <<<_END
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body>
	<div class='header'>
		<h1>Welcome to Athena</h1>
		<div class='headernav'>
		<ul>
			<li><a href='/athena/www/dropoff.php'>Dropoff Trays</a> | </li>
			<li><a href='/athena/www/pickup.php'>Pickup Trays</a> | </li> 
			<li><a href='/athena/www/reservations.php'>Reservations</a> | </li>
			<li><a href='/athena/www/admin.php'>Admin Panel</a></li>				
		</ul>
		</div>
		</div>
		<div class='main'>

_END;

		$loginForm = "<form method='post' action='/athena/www/login.php'>$error" .
		"<span class='fieldname'>Username: </span><input type='text' name='user' /><br/>".
		"<span class='fieldname'>Password: </span><input type='password' name='pass' /><br/>" .
		"<input type='submit' value='Login' /> </form>";
	
		$notLoggedInHeader = <<<_END
			
			<!DOCTYPE html>
<html>
	<head>
		<title>Athena System</title>
	</head>	
	<body>
		<h1>Welcome to Athena</h1>
		<div class='main'><h3>Please enter your username and password to log in</h3>
		<p>$loginForm</p>
		
_END;
			
			if($loggedIn) {
				
				echo $header;
				echo "Current User: $userStr <br/>";
			} else {
				echo $notLoggedInHeader;
				die("<p>Please log in to Athena. <br/> <br/> <a href='login.php'>Click Here</a> to log in.</p>");
				
			}
		}
		
		//this is for pages with dateTime selectors. Its the same as the preceding header function but adds an onload to the body tag
	public function makeScriptHeader() {
		
		//session control
		session_start();
		
		if(isset($_SESSION['user'])) {
			$currentUser = $_SESSION['user'];
			$loggedIn = TRUE;
			$userStr = $currentUser;
			$currentUserId = $_SESSION['userId'];
		} else {
			$loggedIn = FALSE;
			$userStr = "Guest";
			$currentUserId = "";
		}
		
		if(isset($_GET['a'])) {
			$error = "<span class='error'>Login error, please try again</span><br/>";
		} else {
			$error = "";
		}
			
			$header = <<<_END
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body onload='formatTimeSelect()'>
	<div class='header'>
		<h1>Welcome to Athena</h1>
		<div class='headernav'>
		<ul>
			<li><a href='/athena/www/dropoff.php'>Dropoff Trays</a> | </li>
			<li><a href='/athena/www/pickup.php'>Pickup Trays</a> | </li> 
			<li><a href='/athena/www/reservations.php'>Reservations</a> | </li>
			<li><a href='/athena/www/admin.php'>Admin Panel</a></li>				
		</ul>
		</div>
		</div>
		<div class='main'>

_END;

		$loginForm = "<form method='post' action='/athena/www/login.php'>$error" .
		"<span class='fieldname'>Username: </span><input type='text' name='user' /><br/>".
		"<span class='fieldname'>Password: </span><input type='password' name='pass' /><br/>" .
		"<input type='submit' value='Login' /> </form>";
	
		$notLoggedInHeader = <<<_END
			
			<!DOCTYPE html>
<html>
	<head>
		<title>Athena System</title>
	</head>	
	<body>
		<h1>Welcome to Athena</h1>
		<div class='main'><h3>Please enter your username and password to log in</h3>
		<p>$loginForm</p>
		
_END;
			
			if($loggedIn) {
				
				echo $header;
				echo "Current User: $userStr <br/>";
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
			<a href='/athena/www/landing.php'>View Trays</a> | 
			<a href='/athena/www/caseInspector.php'>Your Cases</a> | 
			<a href='/athena/www/userAssignments.php'>View Assignments</a> | 
			<a href='/athena/www/admin.php'>Admin Panel</a> |
			<a href='/athena/www/landing.php'>Home</a> |
			<a href='/athena/www/logout.php'>Logout</a>
			</div>
	</body>
</html>
_END;
			echo $footer;
		}
		
		//creates table timestamp descriptions
		public function timestampLegend() {
			$legend = "<div class='legend'>" .
			"<span class='warning'>Times in orange are within 24 hours from now.</span><br/>" .
			"<span class='error'>Times in red are overdue.</span></div>";
			
			echo $legend;
		
		}
		
		public function sanitizeString($string) {
			$string = strip_tags($string);
			$string = htmlentities($string);
			$string = stripslashes($string);
			$string = mysqli_real_escape_string($string);
			return $string;
		}
		
	}
	
	
	
?>