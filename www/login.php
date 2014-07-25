<?php

	//login.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	echo "<div class='main'><h3>Please enter your username and password to log in</h3>";
	
	$error = $user = $pass = "";
	
	$loginForm = "<form method='post' action='login.php'>$error" .
	"<span class='fieldname'>Username</span><input type='text' name='user' /><br/>".
	"<span class='fieldname'>Password</span><input type='password' name='pass' /><br/>" .
	"<input type='submit' value='Login' /> </form>";
	
	
	if(isset($_POST['user'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		if($user == "" || $pass == "") {
			$error = "Not all fields were entered <br/>";
		} else  {
		
			$pass = "!@#$pass!@#";
			$pass = md5($pass);
			$sql = "SELECT uname, pwd FROM users WHERE uname='$user' AND pwd='$pass'";
			
			$result = $worker->query($sql);
			
			if(mysqli_num_rows($result) == 0) {
				$error = "<span class='error'>Username/Password invalid.</span><br/><br/>";
			} else {
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				die("You are now logged in. Please <a href='landing.php'>Click here</a> to continue.<br/><br/>");
			}
		}
	}
	
	 echo $loginForm;
	 
	 $htmlUtils->makeFooter();
?>
