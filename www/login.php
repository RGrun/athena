<?php

	//login.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	session_start();
	
	$error = $user = $pass = "";
	

	
	$loginForm = "<form method='post' action='login.php'>$error" .
	"Username: <input type='text' name='user' /><br/>".
	"Password: <input type='password' name='pass' /><br/>" .
	"<input type='submit' value='Login' /> </form>";
	
	
	if(isset($_POST['user'])) {
	
		$user = $_POST['user'];
		$pass = $_POST['pass'];

		
		if($user == "" || $pass == "") {
			header("Location: index.php?a=loginError");
		} else  {
		
			$pass = "!@#$pass!@#";
			$pass = md5($pass);
			
			//first, look to see if person logging in is a user
			$sql = "SELECT uname, pwd FROM users WHERE uname='$user' AND pwd='$pass'";
			
			$result = $worker->query($sql);
			
			if(mysqli_num_rows($result) != 0) {
				//see if its a user
				$sql = "SELECT usr_id FROM users WHERE uname='$user'";
				$result3 = $worker->query($sql);
				$row = mysqli_fetch_array($result3);
				
				
				$_SESSION['user'] = $user;
				$_SESSION['userId'] = $row[0];
				$_SESSION['pass'] = $pass;
				header("Location: landing.php");
				
			} else {
				//...or a client
				
				$sql = "SELECT uname, pwd from cilents WHERE uname='$user' AND pwd='$pass'";
				
				$result = $worker->query($sql);
				
				if(mysqli_num_rows($result) !=0 ) {
					$sql = "SELECT cli_id from clients WHERE uname='$user'";
					$result = $worker->query($sql);
					$row = mysqli_fetch_array($result);
					
					$_SESSION['user'] = $user;
					$_SESSION['userId'] = $row[0];
					header("Location: landing.php");
				} else {
					header{"Location: index.php?a=loginError");
				}
			}
		}	
	} else {
		
		$htmlUtils->makeHeader();
		
		echo "Invalid Username/Password combination.";
		
		$htmlUtils->makeFooter();
		
	}
?>
