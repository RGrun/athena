<?php

	//addNewStorage.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
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
	"<table>" .
	"<tr><td>New Location&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" .
	"<tr><td>New Location&#39;s Company: </td><td>$companySelector </tr> </td>" .
	"<tr><td>New Location&#39;s Address: </td><td><input type='text' name='newAddress' /> </td></tr>" .
	"<tr><td>New Location&#39;s City: </td><td><input type='text' name='newCity' /> </td></tr>" .
	"<tr><td>New Location&#39;s State: </td><td><input type='text' name='newState' maxLength='2' /> </td> </tr>" .
	"<tr><td>New Location&#39;s Zip Code: </td><td><input type='text' name='newZip' />	</td></tr>" .
	"<tr><td>Is this location currently active?</td>" .
	"<td>Yes <input type='radio' name='isActive' value='1' checked='checked' />" .
	"No <input type='radio' name='isActive' value='0' /> </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>