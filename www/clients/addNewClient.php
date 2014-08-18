<?php

	//addNewClient.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();

	if(isset($_POST['isActive'])) {
	
		extract($_POST);
		
		if(isset($_POST['newPassword'])) {
			
			$pass= $_POST['newPassword'];
			//$pass = "!@#$pass!@#";
			//$pass = md5($pass);
		} else {
			$pass = "";
		}
		
		$sql = "INSERT INTO clients (active, fname, lname, uname, pwd, email, phone, sms)" .
		"VALUES ('$isActive', '$newFName', '$newLName', '$newUserName', '$pass', '$newEmail', '$newPhone', '$newSMS')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: clients.php" );
		die();
	}
	
	
	echo "<h2>Input new client data:</h2>";
	
	$form = "<form action='addNewClient.php' method='post'>" .
	"<table>" .
	"<tr><td>New Client&#39;s First Name: </td><td><input type='text' name='newFName' /> </td></tr>" .
	"<tr><td>New Client&#39;s Last Name:</td><td> <input type='text' name='newLName' /> </td></tr>" .
	"<tr><td>New Client&#39;s Username: </td><td><input type='text' name='newUserName' /> </td></tr>" .
	"<tr><td>New Client&#39;s Password: </td><td><input type='password' name='newPassword' /> </td></tr>" .
	"<tr><td>New Client&#39;s Email: </td><td><input type='text' name='newEmail' /> </td></tr>" .
	"<tr><td>New Client&#39;s Phone: </td><td><input type='text' name='newPhone' /> </td></tr>" .
	"<tr><td>New Client&#39;s SMS: </td><td><input type='text' name='newSMS' /> </td></tr>" . 
	"<tr><td>Is this client currently active?" .
	"<td>Yes <input type='radio' name='isActive' value='1' checked='checked' />" .
	"No <input type='radio' name='isActive' value='0' /> </td></tr>" .
	"</table>" .
	"<p>New clients are created without any administrator permissions. To add permissions, edit the client's data after creation.</p>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>