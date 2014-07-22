<?php

	//userDetail.php 
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentUsrId = $_GET['uid'];
	
	$_SESSION['currentUserId'] = $currentUsrId;
	
	$sql = "SELECT * FROM users WHERE usr_id='$currentUsrId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeUser = ($active == 1) ? 'Yes' : 'No';
		
		echo "<h2>User Detail for $uname</h2> <br/>";
		
		$table = "<table>" .
		"<tr><td><em>Active User?</em></td><td>$activeUser</td><td><a href='editUserInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>First Name</em></td><td>$fname</td><td><a href='editUserInfo.php?mtd=fname'>Edit</a></td></tr>" .
		"<tr><td><em>Last Name</em></td><td>$uname</td><td><a href='editUserInfo.php?mtd=uname'>Edit</a></td></tr>" .
		"<tr><td><em>Team ID</em></td><td>$team_id</td><td><a href='editUserInfo.php?mtd=team_id'>Edit</a></td></tr>" .
		"<tr><td><em>Email</em></td><td>$email</td><td><a href='editUserInfo.php?mtd=email'>Edit</a></td></tr>" .
		"<tr><td><em>Phone</em></td><td>$phone</td><td><a href='editUserInfo.php?mtd=phone'>Edit</a></td></tr>" .
		"<tr><td><em>SMS</em></td><td>$sms</td><td><a href='editUserInfo.php?mtd=sms'>Edit</a></td></tr>" .
		"</table><br/><br/>";
		
		echo "<p>$table</p>";
	} else {
		echo "Database connection error.";
	}
	 $worker->closeConnection();
	 $htmlUtils->makeFooter();
?>