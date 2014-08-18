<?php

	//addNewRegion.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_POST['newName'])) {
	
		extract($_POST);
		
		$sql = "INSERT INTO regions (name, city, state)" .
		"VALUES ('$newName', '$newCity', '$newState')";
		
		$worker->query($sql);	
		$worker->closeConnection();
		
		header( "Location: regions.php" );
		die();
	}
	
	echo "<h2>Input new region data:</h2>";

	$form = "<form action='addNewRegion.php' method='post'>" .
	"<table>" .
	"<tr><td>New Region&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" .
	"<tr><td>New Region&#39s City: </td><td><input type='text' name='newCity' /> </td></tr>" .
	"<tr><td>New Region&#39;s State (two-letter abbrivation): </td><td><input type='text' maxLength='2' name='newState' /> </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>