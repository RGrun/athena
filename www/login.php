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
				$sql = "SELECT usr_id, team_id, perm FROM users WHERE uname='$user'";
				$result = $worker->query($sql);
				$row = mysqli_fetch_array($result);
				
				//check admin permission
				$a = preg_match("/admin/i", $row[2]);

				if($a == TRUE) $_SESSION['isAdmin'] = TRUE;
				else $_SESSION{'isAdmin'} = FALSE;
				$_SESSION['isClient'] = FALSE;
				
				$_SESSION['user'] = $user;
				$_SESSION['userId'] = $row[0];
				$_SESSION['teamId'] = $row[1];
				
				//figure out user's companies, to be stored in array, needed for tagging info
				$companySql = "SELECT * FROM usr_cmp WHERE usr_id='$row[0]'";
				
				//echo $companySql;
				
				$companyResult = $worker->query($companySql);
				if(mysqli_num_rows($companyResult) != 0) {
					$userCompanies = array();
					while($companyRow = mysqli_fetch_assoc($companyResult)) {
						
						array_push($userCompanies, $companyRow['cmp_id']);

					}
					
					$_SESSION['userCompanies'] = $userCompanies;
				
				} else {
					$_SESSION['userCompanies'] = 0;
				
				}
				
				//figure out if user is a team leader
				$TLSql = "SELECT team_id FROM teams WHERE head_id='$row[0]'";
				//echo $TLSql;
				$TLResult = $worker->query($TLSql);
				if(mysqli_num_rows($TLResult) != 0) {
					$TLRow = mysqli_fetch_array($TLResult);
					$_SESSION['leaderOf'] = $TLRow[0];
				} else {
					$_SESSION['leaderOf'] = 0; //this will be zero if user isnt a team leader
				}
				
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
					$_SESSION['teamId'] = 0;
					
					//there is currently no way to map clients to companies, clients will be able to see global tags only
					$_SESSION['userCompanies'] = 0;
					
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
