<?php

	//addNewDoctor.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
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
	"New Doctor&#39;s Name: <input type='text' name='newName' /> <br/>" . 
	"Is this doctor currently active? <br />" .
	"Yes <input type='radio' name='isActive' value='1' checked='checked' /> <br />" .
	"No <input type='radio' name='isActive' value='0' /> <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>