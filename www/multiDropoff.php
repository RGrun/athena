<?php

	//multiDropoff.php
	//This page is where you can select multiple trays to dropoff from a site
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$usersTeamId = $_SESSION['teamId'];
	
	if(isset($_POST['dropoffSite'])) {
		//this triggers after user selects a site or storage location
		
		$siteId = $_POST['newsites'];
		
		if(preg_match('/stor/', $siteId)) {
			//site is storage
			$siteId = (int) substr($siteId, 4);
			$siteIsStorage = TRUE;
		} else {
			//site is a site
			$siteIsStorage = FALSE;
		}
		
		$sql = "SELECT tray_id, name FROM trays WHERE team_id='$usersTeamId' AND atnow='usr'";
		
		//echo $sourceId;

		$result = $worker->query($sql);
		if($result->num_rows > 0) {
			//build selector
			
			$multiSelectForm = "<form action='multiSignature.php?mtd=dropoff' method='post' name='traySelector'>";
		
			while($row = mysqli_fetch_array($result)) {
				
				$multiSelectForm .= "<label>$row[1]<input type='checkbox' name='tray[]' value='$row[0]' /></label></br>";
			
			}
			
			if($siteIsStorage) {
				$multiSelectForm .= "<input type='hidden' name='storage' value='$siteId' />";
			}
			if(!$siteIsStorage) {
				$multiSelectForm .= "<input type='hidden' name='site' value='$siteId' />";
			
			}
			
			$multiSelectForm .= "<br/><input type='submit' value='Proceed'/></form>";
			
			echo "<p>Select the trays you're dropping off:</p>";
			
			echo $multiSelectForm;
		} else {
		
			echo "<p>You have no trays.</p>";
			echo "<a href='/athena/www/dropoff.php'>Return</a>";
		}
		

		
	} else {
		//on first run through, this is displayed
		$siteSelector = $worker->createSelector("sites", "name", "site_id", false, false, true);
		
		$form = "<form action='multiDropoff.php' method='post'>" .
			"Where are you dropping off the trays? $siteSelector <br/>".
			"<input type='hidden' name='dropoffSite' value='1'/>" .
			"<input id='proceedButton' type='submit' value='Select' /> </form>";
			
		echo $form;
	
	
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
	
	
?>