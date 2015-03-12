<?php

	#Index.php
	#Main site login page
	
	include_once "includes.php";
	
	$error = "";
	
	#check for login
	
	session_start();
	
	if(!empty($_SESSION)) {
		header("Location: home.php");
		die();
	
	}
	
	if(isset($_POST['userName'])) {
	
		$gremlin = new Gremlin();
		
		$username = $_POST['userName'];
		$rawPW = $_POST['pwd'];

		#check inputted password
		$userType = User::checkPassword($username, $rawPW);
		if($userType != "not found") {
			#login successful
			
			session_start();
			
			#find user's ID
			
			
			if($userType == "user") {
				$sql = "SELECT usr_id FROM users WHERE uname='$username'";
			
				$rawData = $gremlin->query($sql);
			
				$userID = $rawData['usr_id'];
				
				$loggedInUser = $userID;
			} else if($userType == "client") {
			
				$sql = "SELECT cli_id FROM clients WHERE uname='$username'";
			
				$rawData = $gremlin->query($sql);
			
				$cliID = $rawData['cli_id'];
			
			
				$loggedInUser = $userID;
			}
			
			
			
			#set up needed session vars and redirect into system
			$_SESSION['userID'] = $loggedInUser;
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['userType'] = $userType;
			
			header("Location: home.php");
			die();

		} else {
		
			#login failed
			$error = "<span class='error'>Invalid username/password</span>";
		
		}
	
	
	}
	
	#real page starts here
	
	$page = "";
	
	#not including gremlin here, so we'll need to build the login page from scratch
	
	$page .= "<!DOCTYPE HTML>";
	$page .= "<head>";
	$page .= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	$page .= "<meta content='utf-8' http-equiv='encoding'>";
	$page .= "<title>Athena System</title>";
	
	#build styling for this page
	$style = "<style>" .
	"body {
		margin:50px 0px; padding:0px;
		text-align:center;
	}
	" .
	".pageBody {
		margin: 0px auto;

	}" .
	".loginForm {
		position: relative;
		margin: 0px auto;
		width: 240px;
	}" .
	"</style>";
	
	$page .= $style;
	
	$page .= "</head></body>";
	
	
	#actual page starts here
	$page .= "<div class='pageBody'>"; #open pageBody
	
	$logo = "<img class='loginLogo' src='core/images/athena-logo.png'/>'";
	
	$form = "<div class='loginForm'><form method='post' action='index.php'>";
	$form .= "<table class='loginTable'>";
	$form .= "$error" .
	"<tr><td>Username: </td><td><input type='text' name='userName' /> </td></tr>" .
	"<tr><td>Password: </td><td><input type='password' name='pwd' /> </td></tr>" .
	"<tr><td><input type='submit' value='Login' /> </td></tr></table></form></div>";
	
	$page .= $logo . $form;
	
	$page .= "</div>"; #end pageBody
	
	$page .= "</body></html>";
			
	
	echo $page;


?>