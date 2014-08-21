<?php

	//addNewInstrument.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_POST['newName'])) {
	
		extract($_POST);
		
		$sql = "INSERT INTO instruments (name, partno)" .
		"VALUES ('$newName', '$newPartno')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: instruments.php" );
		die();
	}
	
	
	echo "<h2>Input new instrument data:</h2>";
	
	$form = "<form action='addNewInstrument.php' method='post'>" .
	"<table>" .
	"<tr><td>New Instrument&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" . 
	"<tr><td>Part Number: </td><td><input type='text' name='newPartno' /> </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>