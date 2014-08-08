<?php

	//addNewTray.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['added'])) {
	
		extract($_POST);
		

		$sql = "INSERT INTO trays (name, cmp_id, team_id, site_id, atnow, stor_id)" .
		"VALUES ('$newName', '$newcompany', '$newteams', '$newsites', '$newStatus', '$newstorage')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: trays.php" );
		die();
	}
	
	
	echo "<h2>Input new tray data:</h2>";
	
	$companySelector = $worker->createSelector("company", "name", "cmp_id");
	$teamSelector = $worker->createSelector("teams", "name", "team_id");
	$siteSelector = $worker->createSelector("sites", "name", "site_id");
	$storageSelector = $worker->createSelector("storage", "name", "stor_id");
	
	$statusSelector = "<select name='newStatus' size='1'>" .
		"<option value='stor'>In Storage</option>" .
		"<option value='usr'>With User</option>" .
		"<option value='site'>At Site</option>" .
		"<option value='unk'>Unkown</option>" .
		"</select>";
	
	$form = "<form action='addNewTray.php?added=true' method='post'>" .
	"New Tray&#39;s Name: <input type='text' name='newName' /> <br/>" .
	"New Tray&#39;s Company: $companySelector <br />" .
	"Team Responsible for Tray: $teamSelector <br />" .
	"New Tray&#39;s Location: $siteSelector <br />" .
	"New Tray&#39;s Storage Location: $storageSelector <br/>" .
	"New Tray&#39;s Status: $statusSelector <br/>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>