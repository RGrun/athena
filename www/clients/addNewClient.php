<?php

	//addNewClient.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();

	if(isset($_POST['isActive'])) {
	
		extract($_POST);
		
		if(isset($_POST['newPassword'])) $pass = md5($_POST['newPassword']);
		else $pass = "";
		
		$sql = "INSERT INTO clients (active, fname, lname, uname, pwd, email, phone, sms)" .
		"VALUES ('$isActive', '$newFName', '$newLName', '$newUserName', '$pass', '$newEmail', '$newPhone', '$newSMS')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: clients.php" );
		die();
	}
	
	
	echo "<h2>Input new client data:</h2>";
	
	$form = "<form action='addNewClient.php' method='post'>" .
	"New Client&#39;s First Name: <input type='text' name='newFName' /> <br/>" .
	"New Client&#39;s Last Name: <input type='text' name='newLName' /> <br/>" .
	"New Client&#39;s Username: <input type='text' name='newUserName' /> <br />" .
	"New Client&#39;s Password: <input type='password' name='newPassword' /> <br />" .
	"New Client&#39;s Email: <input type='text' name='newEmail' /> <br />" .
	"New Client&#39;s Phone: <input type='text' name='newPhone' /> <br />" .
	"New Client&#39;s SMS: <input type='text' name='newSMS' /> <br/>" . 
	"Is this client currently active? <br />" .
	"Yes <input type='radio' name='isActive' value='1' checked='checked' /> <br />" .
	"No <input type='radio' name='isActive' value='0' /> <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>