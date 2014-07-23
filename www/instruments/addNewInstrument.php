<?php

	//addNewInstrument.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
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
	"New Instrument&#39;s Name: <input type='text' name='newName' /> <br/>" . 
	"Part Number: <input type='text' name='newPartno' /> <br/>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>