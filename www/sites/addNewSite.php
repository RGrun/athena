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
	"New Site&#39;s Name: <input type='text' name='newName' /> <br/>" .
	"New Site&#39;s Address: <input type='text' name='newAddress' /> <br/>" .
	"New Site&#39s City: <input type='text' name='newCity' /> <br/>" .
	"New Site&#39;s State (two-letter abbrivation): <input type='text' maxLength='2' name='newState' /> <br />" .
	"New Site&#39;s Zip Code: <input type='text' maxLength='5' name='newZip' /> <br />" .
	"New Site&#39;s Fax: <input type='text' name='newFax' maxLength='10' /> <br />" .
	"Is this site currently active? <br />" .
	"Yes <input type='radio' name='isActive' value='1' checked='checked' /> <br />" .
	"No <input type='radio' name='isActive' value='0' /> <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>