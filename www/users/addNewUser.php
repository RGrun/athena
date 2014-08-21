<?php

	//addNewUser.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_POST['isActive'])) {
	
		extract($_POST);
		
		//this salts the password
		if(isset($_POST['newPassword'])) {
			
			$pass= $_POST['newPassword'];
			//$pass = "!@#$pass!@#";
			//$pass = md5($pass);
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
	"<table>" .
	"<tr><td>New User&#39;s First Name: </td><td><input type='text' name='newFName' /> </td></tr>" .
	"<tr><td>New User&#39;s Last Name: </td><td><input type='text' name='newLName' /> </td></tr>" .
	"<tr><td>New User&#39s Team: </td><td>$teamSelector </td></tr>" .
	"<tr><td>New User&#39;s Username: </td><td><input type='text' name='newUsername' /> </td> </tr>" .
	"<tr><td>New User&#39;s Password: </td><td><input type='password' name='newPassword' /> </td></tr>" .
	"<tr><td>New User&#39;s Email: </td><td><input type='text' name='newEmail' /> </td></tr>" .
	"<tr><td>New User&#39;s Phone: </td><td><input type='text' name='newPhone' /> </td></tr>" .
	"<tr><td>New User&#39;s SMS: </td><td><input type='text' name='newSMS' /> </td></tr>" . 
	"<tr><td>Is this user currently active?" .
	"<td>Yes <input type='radio' name='isActive' value='1' checked='checked' />" .
	"No <input type='radio' name='isActive' value='0' /> </td></tr>" .
	"</table>" .
	"<p>New users are created without any administrator permissions. To add permissions, edit the user's data after creation.</p>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
	