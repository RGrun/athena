<?php

	//addNewUser.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	if(isset($_POST['isActive'])) {
	
		extract($_POST);
		
		if(isset($_POST['newPassword'])) {
			
			$pass= $_POST['newPassword'];
			$pass = "!@#$pass!@#";
			$pass = md5($pass);
		} else {
			$pass = "";
		}
		
		
		$sql = "INSERT INTO users (active, team_id, fname, lname, uname, pwd, email, phone, sms)" .
		"VALUES ('$isActive', '$newteams', '$newFName', '$newLName', '$newUsername', '$pass', '$newEmail', '$newPhone', '$newSMS')";
				
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: users.php" );
		die();
	}
	
	
	echo "<h2>Input new user data:</h2>";
	
	$teamSelector = $worker->createSelector("teams", "name", "team_id");


	$form = "<form action='addNewUser.php' method='post'>" .
	"New User&#39;s First Name: <input type='text' name='newFName' /> <br/>" .
	"New User&#39;s Last Name: <input type='text' name='newLName' /> <br/>" .
	"New User&#39s Team: $teamSelector <br/>" .
	"New User&#39;s Username: <input type='text' name='newUsername' /> <br />" .
	"New User&#39;s Password: <input type='password' name='newPassword' /> <br />" .
	"New User&#39;s Email: <input type='text' name='newEmail' /> <br />" .
	"New User&#39;s Phone: <input type='text' name='newPhone' /> <br />" .
	"New User&#39;s SMS: <input type='text' name='newSMS' /> <br/>" . 
	"Is this user currently active? <br />" .
	"Yes <input type='radio' name='isActive' value='1' checked='checked' /> <br />" .
	"No <input type='radio' name='isActive' value='0' /> <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
	