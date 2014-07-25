<?php

	//login.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$worker = new dbWorker();
		
	$error = $user = $pass = "";
	
	$loginForm = "<form method='post' action='login.php'>$error" .
	"<span class='fieldname'>Username</span><input type='text' name='user' /><br/>".
	"<span class='fieldname'>Password</span><input type='password' name='pass' /><br/>" .
	"<input type='submit' value='Login' /> </form>";
	
	
	if(isset($_POST['user'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		if($user == "" || $pass == "") {
			//$error = "Not all fields were entered <br/>";
			header("Location: index.php?a=loginError");
		} else  {
		
			$pass = "!@#$pass!@#";
			$pass = md5($pass);
			$sql = "SELECT uname, pwd FROM users WHERE uname='$user' AND pwd='$pass'";
			
			$result = $worker->query($sql);
			
			if(mysqli_num_rows($result) == 0) {
				$error = "<span class='error'>Username/Password invalid.</span><br/><br/>";
			} else {
				$sql = "SELECT usr_id FROM users WHERE uname='$user'";
				$result2 = $worker->query($sql);
				$row = mysqli_fetch_array($result2);
				
				
				$_SESSION['user'] = $user;
				$_SESSION['userId'] = $row[0];
				$_SESSION['pass'] = $pass;
				die("You are now logged in. Please <a href='landing.php'>Click here</a> to continue.<br/><br/>");
			}
		}
	}
	
?>
