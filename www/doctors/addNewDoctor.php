<?php

	//addNewDoctor.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_POST['isActive'])) {
	
		extract($_POST);
		
		$sql = "INSERT INTO doctors (active, name)" .
		"VALUES ('$isActive', '$newName')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: doctors.php" );
		die();
	}
	
	
	echo "<h2>Input new doctor data:</h2>";
	
	$form = "<form action='addNewDoctor.php' method='post'>" .
	"<table>" .
	"<tr><td>New Doctor&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" . 
	"<tr><td>Is this doctor currently active? </td>" .
	"<td>Yes <input type='radio' name='isActive' value='1' checked='checked' /> " .
	"No <input type='radio' name='isActive' value='0' /> </td>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>