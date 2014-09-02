<?php

	//multiPickup.php
	//This page is where you can select multiple trays to pickup from a site
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_POST['pickupSite'])) {
		//this triggers after user selects a site or storage location
		
		$siteId = $_POST['newsites'];
		
		if(preg_match('/stor/', $siteId)) {
			//site is storage
			$sourceId = (int) substr($siteId, 4);
			$siteIsStorage = TRUE;
		} else {
			//site is a site
			$sourceId = $siteId;
			$siteIsStorage = FALSE;
		}
		
		if(!$siteIsStorage) $sql = "SELECT tray_id, name FROM trays WHERE site_id='$sourceId' AND atnow='site'";
		else $sql = "SELECT tray_id, name FROM trays WHERE stor_id='$sourceId' AND atnow='stor'";

		$result = $worker->query($sql);
		if($result->num_rows > 0) {
			//build selector
			
			$multiSelectForm = "<form action='multiSignature.php?mtd=pickup' method='post' name='traySelector'>";
		
			while($row = mysqli_fetch_array($result)) {
				
				$multiSelectForm .= "<label>$row[1]<input type='checkbox' name='tray[]' value='$row[0]' /></label></br>";
			
			}
			
			$multiSelectForm .= "<br/><input type='submit' value='Proceed'/></form>";
			
			echo "<p>Select the trays you're picking up:</p>";
			echo $multiSelectForm;
		} else {
		
			echo "<p>No trays are currently at that location</p>";
			echo "<a href='/athena/www/pickup.php'>Return</a>";
		}
		

		
	} else {
		//on first run through, this is displayed
		$siteSelector = $worker->createSelector("sites", "name", "site_id", false, false, true);
		
		$form = "<form action='multiPickup.php' method='post'>" .
			"Where are you picking up trays from? $siteSelector <br/>".
			"<input type='hidden' name='pickupSite' value='1'/>" .
			"<input id='proceedButton' type='submit' value='Select' /> </form>";
			
		echo $form;
	
	
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
	
	
?>