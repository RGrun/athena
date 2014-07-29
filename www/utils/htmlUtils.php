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
		
		if(isset($_GET['a'])) {
			$error = "<span class='error'>Login error, please try again</span><br/>";
		} else {
			$error = "";
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
		<div class='headernav'>
		<ul>
			<li><a href='/athena/www/landing.php'>Return to Landing</a> | </li> 
			<li><a href='/athena/www/userAssignments.php'>View Assignments</a> | </li>
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
			<a href='/athena/www/index.php'>Home</a> |
			<a href='/athena/www/logout.php'>Logout</a>
			</div>
	</body>
</html>
_END;
			echo $footer;
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