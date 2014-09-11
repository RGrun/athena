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
			$userIsAdmin = $_SESSION['isAdmin']; //admin permission
			$userIsClient = $_SESSION['isClient']; //check to see if client
			$loggedIn = TRUE;
			$userStr = $currentUser;
			$currentUserId = $_SESSION['userId'];
			
			$teamId = $_SESSION['teamId'];
			
			//figure out number of notifications
			$notiSql = "SELECT COUNT(un_id) FROM unotifs WHERE usr_id='$teamId' AND hidden='0'";
			$quickWorker = new dbWorker();
			$notiResult = $quickWorker->query($notiSql);
			$notiRow = mysqli_fetch_array($notiResult);
			$noOfNotifications = $notiRow[0];
			
			$quickWorker->closeConnection();
			$quickWorker = null;
			
			date_default_timezone_set('America/Los_Angeles');
			
		} else {
			$loggedIn = FALSE;
			$userStr = "Guest";
			$currentUserId = "";
			$noOfNotifications =  "";
			date_default_timezone_set('America/Los_Angeles');
		}
		
		if(isset($_GET['a'])) {
			$error = "<span class='error'>Login error, please try again</span><br/>";
		} else {
			$error = "";
		}
			
			$adminHeader = <<<_END
<!DOCTYPE html>
<html>
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body>
		<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
				<div id='notifications'>
					<a href='/athena/www/notifications.php'><span id='notificationText'>Notifications: $noOfNotifications</span></a>
				</div>
				<div class='username'>
					<span id='username'>User: $userStr</span>
				</div>
				<div class='logView'>
					<a href='/athena/www/logs/logs.php'><span id='logIcon'>&#x1f4d6;</span> <span id='logText'>View Logs</span></a>
				</div>
				<div class='extras'>
					<ul>
						<a href='/athena/www/settings.php'><li><span id='extraicon'>&#x2699;</span>Settings</li></a>
						<a href='/athena/www/logout.php'><li><span id='extraicon'>&#x1f6aa;</span>Logout</li></a>
					</ul>
			</div>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
				<ul>
						<a href='/athena/www/dropoff.php'><li><span id='icon'>&#x21f2;</span>DROP OFF TRAYS</li></a>
						<a href='/athena/www/pickup.php'><li><span id='icon'>&#x21f1;</span>PICK UP TRAYS</li></a>
						<a href='/athena/www/reservations.php'><li><span id='icon'>&#x1f551;</span>RESERVATIONS</li></a>
						<a href='/athena/www/admin.php'><li><span id='icon'>&#x26a0;</span>ADMIN PANEL</li></a>				
				</ul>
			</div>
		</div>	
		
	</div>
		<div class='main'>

_END;

			$clientHeader = <<<_END
<!DOCTYPE html>
<html>
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body>
		<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
				<div id='notifications'>
					<a href='/athena/www/notifications.php'><span id='notificationText'>Notifications: $noOfNotifications</span></a>
				</div>
				<div class='username'>
					<span id='username'>Client: $userStr</span>
				</div>
				<div class='extras'>
					<ul>
						<a href='/athena/www/settings.php'><li><span id='extraicon'>&#x2699;</span>Settings</li></a>
						<a href='/athena/www/logout.php'><li><span id='extraicon'>&#x1f6aa;</span>Logout</li></a>
					</ul>
			</div>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
				<ul>
						<a href='/athena/www/reservations.php'><li><span id='icon'>&#x1f551;</span>RESERVATIONS</li></a>			
				</ul>
			</div>
		</div>	
		
	</div>
		<div class='main'>

_END;

			$header = <<<_END
<!DOCTYPE html>
<html>
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body>
		<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
				<div id='notifications'>
					<a href='/athena/www/notifications.php'><span id='notificationText'>Notifications: $noOfNotifications</span></a>
				</div>
				<div class='username'>
					<span id='username'>User: $userStr</span>
				</div>
				<div class='extras'>
					<ul>
						<a href='/athena/www/settings.php'><li><span id='extraicon'>&#x2699;</span>Settings</li></a>
						<a href='/athena/www/logout.php'><li><span id='extraicon'>&#x1f6aa;</span>Logout</li></a>
					</ul>
			</div>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
				<ul>
						<a href='/athena/www/dropoff.php'><li><span id='icon'>&#x21f2;</span>DROP OFF TRAYS</li></a>
						<a href='/athena/www/pickup.php'><li><span id='icon'>&#x21f1;</span>PICK UP TRAYS</li></a>
						<a href='/athena/www/reservations.php'><li><span id='icon'>&#x1f551;</span>RESERVATIONS</li></a>			
				</ul>
			</div>
		</div>	
		
	</div>
		<div class='main'>

_END;

		$loginForm = "<form method='post' action='/athena/www/login.php'>$error" .
		"<table>" .
		"<tr><td>Username: </td><td><input type='text' name='user' /></td></tr>".
		"<tr><td>Password: </td><td><input type='password' name='pass' /></td></tr>" .
		"</table>" .
		"<input type='submit' value='Login' /> </form>";
	
		$notLoggedInHeader = <<<_END
			
			<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body>
		<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
			</div>
		</div>	
		
	</div>
		<div class='main'>
			<div class='welcomeArea'>
				<div class='welcomeHeader'>
					<h2>Welcome to Athena</h2>
				</div>
				<div class='welcomeHeader'>
					<h3>Please enter your username and password to log in</h3>
				</div>
			</div>
		<div class='loginArea'>
			<div class='loginForm'>
				$loginForm
			</div>
		</div>
		
_END;
			
			if($loggedIn && $userIsAdmin) {
				
				echo $adminHeader;
				
			} else if($loggedIn && $userIsClient) {
			
				echo $clientHeader;
			
			} else if($loggedIn) {
			
				echo $header;
			
			} else {
				echo $notLoggedInHeader;
				die();
				
			}
		}
		
		//this is for pages with dateTime selectors. Its the same as the preceding header function but adds an onload to the body tag
	public function makeScriptHeader() {
		
		//session control
		session_start();
		
		if(isset($_SESSION['user'])) {
			$currentUser = $_SESSION['user'];
			$userIsAdmin = $_SESSION['isAdmin']; //admin permission
			$userIsClient = $_SESSION['isClient']; //check if client
			$loggedIn = TRUE;
			$userStr = $currentUser;
			$currentUserId = $_SESSION['userId'];
			
			$teamId = $_SESSION['teamId'];
			
			//figure out number of notifications
			$notiSql = "SELECT COUNT(un_id) FROM unotifs WHERE usr_id='$teamId' AND hidden='0'";
			$quickWorker = new dbWorker();
			$notiResult = $quickWorker->query($notiSql);
			$notiRow = mysqli_fetch_array($notiResult);
			$noOfNotifications = $notiRow[0];
			
			$quickWorker->closeConnection();
			$quickWorker = null;
			
			date_default_timezone_set('America/Los_Angeles');
		} else {
			$loggedIn = FALSE;
			$userStr = "Guest";
			$currentUserId = "";
			$noOfNotifications =  "";
			date_default_timezone_set('America/Los_Angeles');
		}
		
		if(isset($_GET['a'])) {
			$error = "<span class='error'>Login error, please try again</span><br/>";
		} else {
			$error = "";
		}
			
			
			$adminHeader = <<<_END
<!DOCTYPE html>
<html>
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body onload='formatTimeSelect()'>
		<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
				<div id='notifications'>
					<a href='/athena/www/notifications.php'><span id='notificationText'>Notifications: $noOfNotifications</span></a>
				</div>
				<div class='username'>
					<span id='username'>User: $userStr</span>
				</div>
				<div class='logView'>
					<a href='/athena/www/logs/logs.php'><span id='logIcon'>&#x1f4d6;</span> <span id='logText'>View Logs</span></a>
				</div>
				<div class='extras'>
					<ul>
						<a href='/athena/www/settings.php'><li><span id='extraicon'>&#x2699;</span>Settings</li></a>
						<a href='/athena/www/logout.php'><li><span id='extraicon'>&#x1f6aa;</span>Logout</li></a>
					</ul>
			</div>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
				<ul>
						<a href='/athena/www/dropoff.php'><li><span id='icon'>&#x21f2;</span>DROP OFF TRAYS</li></a>
						<a href='/athena/www/pickup.php'><li><span id='icon'>&#x21f1;</span>PICK UP TRAYS</li></a>
						<a href='/athena/www/reservations.php'><li><span id='icon'>&#x1f551;</span>RESERVATIONS</li></a>
						<a href='/athena/www/admin.php'><li><span id='icon'>&#x26a0;</span>ADMIN PANEL</li></a>				
				</ul>
			</div>
		</div>	
		
	</div>
		<div class='main'>

_END;

			$clientHeader = <<<_END
<!DOCTYPE html>
<html>
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body>
		<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
				<div id='notifications'>
					<a href='/athena/www/notifications.php'><span id='notificationText'>Notifications: $noOfNotifications</span></a>
				</div>
				<div class='username'>
					<span id='username'>Client: $userStr</span>
				</div>
				<div class='extras'>
					<ul>
						<a href='/athena/www/settings.php'><li><span id='extraicon'>&#x2699;</span>Settings</li></a>
						<a href='/athena/www/logout.php'><li><span id='extraicon'>&#x1f6aa;</span>Logout</li></a>
					</ul>
			</div>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
				<ul>
						<a href='/athena/www/reservations.php'><li><span id='icon'>&#x1f551;</span>RESERVATIONS</li></a>			
				</ul>
			</div>
		</div>	
		
	</div>
		<div class='main'>

_END;
			
			
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
			<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
				<div id='notifications'>
					<a href='/athena/www/notifications.php'><span id='notificationText'>Notifications: $noOfNotifications</span></a>
				</div>
				<div class='username'>
					<span id='username'>User: $userStr</span>
				</div>
				<div class='extras'>
					<ul>
						<a href='/athena/www/settings.php'><li><span id='extraicon'>&#x2699;</span>Settings</li></a>
						<a href='/athena/www/logout.php'><li><span id='extraicon'>&#x1f6aa;</span>Logout</li></a>
					</ul>
			</div>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
				<ul>
						<a href='/athena/www/dropoff.php'><li><span id='icon'>&#x21f2;</span>DROP OFF TRAYS</li></a>
						<a href='/athena/www/pickup.php'><li><span id='icon'>&#x21f1;</span>PICK UP TRAYS</li></a>
						<a href='/athena/www/reservations.php'><li><span id='icon'>&#x1f551;</span>RESERVATIONS</li></a>		
				</ul>
			</div>
		</div>	
		
	</div>
		<div class='main'>

_END;

		$loginForm = "<form method='post' action='/athena/www/login.php'>$error" .
		"<table>" .
		"<tr><td>Username: </td><td><input type='text' name='user' /></td></tr>".
		"<tr><td>Password: </td><td><input type='password' name='pass' /></td></tr>" .
		"</table>" .
		"<input type='submit' value='Login' /> </form>";
	
		$notLoggedInHeader = <<<_END
			
			<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta content="utf-8" http-equiv="encoding">
		<title>Athena System</title>
		<link rel="stylesheet" type="text/css" href="/athena/www/styles.css">
		<script src='/athena/www/helperFunctions.js'></script>
	</head>	
	<body>
		<div class='dashboard'>
		<div id='header'>
			<div class='wrapper'>
				<a href="/athena/www/landing.php">
					<img id='logo' src="/athena/www/utils/images/athena-logo.png"/>
				</a>
			</div>
		</div>
		<div class='headernav'>
			<div class='wrapper'>		
			</div>
		</div>	
		
	</div>
		<div class='main'>
			<div class='welcomeArea'>
				<div class='welcomeHeader'>
					<h2>Welcome to Athena</h2>
				</div>
				<div class='welcomeHeader'>
					<h3>Please enter your username and password to log in</h3>
				</div>
			</div>
		<div class='loginArea'>
			<div class='loginForm'>
				$loginForm
			</div>
		</div>
		
_END;
			
			if($loggedIn && $userIsAdmin) {
				
				echo $adminHeader;
				
			} else if($loggedIN && $userIsClient) {
			
				echo $clientHeader;
				
			} else if($loggedIn) {
			
				echo $header;
			} else {
				echo $notLoggedInHeader;
				die();
				
			}
		}
		
		
		//closes up the page
		public function makeFooter() {
		
			//keeping these here just in case, even though they're no longer used
			/*<div class='footer'>
			<a href='/athena/www/landing.php'>View Trays</a> | 
			<a href='/athena/www/caseInspector.php'>Your Cases</a> | 
			<a href='/athena/www/userAssignments.php'>View Assignments</a> | 
			<a href='/athena/www/admin.php'>Admin Panel</a> |
			<a href='/athena/www/landing.php'>Home</a> |
			<a href='/athena/www/logout.php'>Logout</a>
			</div>*/
		
			$footer = <<<_END
			
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