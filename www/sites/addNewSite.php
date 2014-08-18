<?php

	//addNewSite.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_POST['isActive'])) {
	
		extract($_POST);
		
		$sql = "INSERT INTO sites (active, name, address, city, state, zip, fax)" .
		"VALUES ('$isActive', '$newName', '$newAddress', '$newCity', '$newState', '$newZip', '$newFax')";
		
		$worker->query($sql);	
		$worker->closeConnection();
		
		header( "Location: sites.php" );
		die();
	}
	
	echo "<h2>Input new site data:</h2>";

	$form = "<form action='addNewSite.php' method='post'>" .
	"<table>" .
	"<tr><td>New Site&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" .
	"<tr><td>New Site&#39;s Address: </td><td><input type='text' name='newAddress' /> </td></tr>" .
	"<tr><td>New Site&#39s City: </td><td><input type='text' name='newCity' /> </td></tr>" .
	"<tr><td>New Site&#39;s State (two-letter abbrivation): </td><td><input type='text' maxLength='2' name='newState' /> </td></tr>" .
	"<tr><td>New Site&#39;s Zip Code: </td><td><input type='text' maxLength='5' name='newZip' /> </td></tr>" .
	"<tr><td>New Site&#39;s Fax: </td><td><input type='text' name='newFax' maxLength='10' /> </td></tr>" .
	"<tr><td>Is this site currently active? </td>" .
	"<td>Yes <input type='radio' name='isActive' value='1' checked='checked' />" .
	"No <input type='radio' name='isActive' value='0' /> </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>