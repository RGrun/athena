<?php

	//addNewStorage.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_POST['isActive'])) {
	
		extract($_POST);
		
		$sql = "INSERT INTO storage (cmp_id, active, name, address, city, state, zip)" .
		"VALUES ('$newcompany', '$isActive', '$newName', '$newAddress', '$newCity', '$newState', '$newZip')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		
		header( "Location: storage.php" );
		die();
	}
	
	
	echo "<h2>Input new storage location data:</h2>";
	
	$companySelector = $worker->createSelector("company", "name", "cmp_id");
	
	$form = "<form action='addNewStorage.php' method='post'>" .
	"New Location&#39;s Name: <input type='text' name='newName' /> <br/>" .
	"New Location&#39;s Company: $companySelector <br />" .
	"New Location&#39;s Address: <input type='text' name='newAddress' /> <br />" .
	"New Location&#39;s City: <input type='text' name='newCity' /> <br/>" .
	"New Location&#39;s State: <input type='text' name='newState' maxLength='2' /> <br/>" .
	"New Location&#39;s Zip Code: <input type='text' name='newZip' />	<br/>" .
	"Is this location currently active? <br />" .
	"Yes <input type='radio' name='isActive' value='1' checked='checked' /> <br />" .
	"No <input type='radio' name='isActive' value='0' /> <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>