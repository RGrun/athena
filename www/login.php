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
			die();
		} else  {
		
			//REENABLE PASSWORD ENCODING IN FINAL PRODUCT
			
			//$pass = "!@#$pass!@#";
			//$pass = md5($pass);
			
			//first, look to see if person logging in is a user, and check their permissions
			$sql = "SELECT uname, perm FROM users WHERE uname='$user' AND pwd='$pass'";
			
			$result = $worker->query($sql);
			
			if(mysqli_num_rows($result) != 0) {
				//see if its a user
				$sql = "SELECT usr_id, perm FROM users WHERE uname='$user'";
				$result = $worker->query($sql);
				$row = mysqli_fetch_array($result);
				
				//check admin permission
				$a = preg_match("/admin/i", $row[1]);
				
				
				if($a == TRUE) $_SESSION['isAdmin'] = TRUE;
				else $_SESSION{'isAdmin'} = FALSE;
				$_SESSION['isClient'] = FALSE;
				
				$_SESSION['user'] = $user;
				$_SESSION['userId'] = $row[0];
				header("Location: landing.php");
				die();
			} else {
				//...or a client
				$sql = "SELECT uname, perm from clients WHERE uname='$user' AND pwd='$pass'";
				//echo $sql;
				$result = $worker->query($sql);
				
				if(mysqli_num_rows($result) != 0 ) {
					$sql = "SELECT cli_id, perm from clients WHERE uname='$user'";
					$result = $worker->query($sql);
					$row = mysqli_fetch_array($result);
					
						
					//check admin permission
					$a = preg_match("/admin/i", $row[1]);
					
					
					if($a == TRUE) $_SESSION['isAdmin'] = TRUE;
					else $_SESSION{'isAdmin'} = FALSE;
					$_SESSION['isClient'] = TRUE;
					
					$_SESSION['user'] = $user;
					$_SESSION['userId'] = $row[0];
					header("Location: landing.php");
					die();
				} else {
					header("Location: index.php?a=loginError");
					die();
				}
			}
		}	
	} else {
		
		$htmlUtils->makeHeader();
		
		echo "Invalid Username/Password combination.";
		
		$htmlUtils->makeFooter();
		
	}
?>
