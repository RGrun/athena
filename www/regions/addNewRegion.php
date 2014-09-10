<?php

	//addNewRegion.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_POST['newName'])) {
	
		extract($_POST);
		
		$sql = "INSERT INTO regions (cmp_id, name, city, state)" .
		"VALUES ('$newcompany', '$newName', '$newCity', '$newState')";
		
		//echo $sql;
		
		$worker->query($sql);	
		$worker->closeConnection();
		
		header( "Location: regions.php" );
		die();
	}
	
	echo "<h2>Input new region data:</h2>";
	
	$companySelector = $worker->createSelector("company", "name", "cmp_id", true);

	$form = "<form action='addNewRegion.php' method='post'>" .
	"<table>" .
	"<tr><td>New Region&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" .
	"<tr><td>New Region&#39s City: </td><td><input type='text' name='newCity' /> </td></tr>" .
	"<tr><td>Primary Company:</td><td> $companySelector </td></tr>" .
	"<tr><td>New Region&#39;s State (two-letter abbrivation): </td><td><input type='text' maxLength='2' name='newState' /> </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>