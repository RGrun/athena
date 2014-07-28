<?php

	//login.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	session_start();
	
	$error = $user = $pass = "";
	
	if(isset($_GET['a'])) {
		$error = "Not all fields were entered <br/>";
	}
	
	$loginForm = "<form method='post' action='login.php'>$error" .
	"Username: <input type='text' name='user' /><br/>".
	"Password: <input type='password' name='pass' /><br/>" .
	"<input type='submit' value='Login' /> </form>";
	
	
	if(isset($_POST['user'])) {
	
		//clean up user inupt
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		echo $user;
		echo $pass;
		
		if($user == "" || $pass == "") {
			header("Location: index.php?a=loginError");
		} else  {
		
			$pass = "!@#$pass!@#";
			$pass = md5($pass);
			
			//first, look to see if person logging in is a user
			$sql = "SELECT uname, pwd FROM users WHERE uname='$user' AND pwd='$pass'";
			
			$result = $worker->query($sql);
			
			if(mysqli_num_rows($result) == 0) {
				$error = "<br/><span class='error'>Username/Password invalid.</span><br/>";
			} else {
				
				$sql = "SELECT usr_id FROM users WHERE uname='$user'";
				$result3 = $worker->query($sql);
				$row = mysqli_fetch_array($result3);
				
				
				$_SESSION['user'] = $user;
				$_SESSION['userId'] = $row[0];
				$_SESSION['pass'] = $pass;
				header("Location: landing.php");
				die("You are now logged in. Please <a href='landing.php'>Click here</a> to continue.<br/><br/>");
			}
		}	
	} else {
		
		$htmlUtils->makeHeader();
		
		echo "Invalid Username/Password combination.";
		
		$htmlUtils->makeFooter();
		
	}
?>
