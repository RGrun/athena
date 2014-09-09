<?php

	//editTrayTypeInfo.php
	//same as other admin editing pages, only for tray types
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_GET['mtd'])){
		$selectedMethod = $_GET['mtd'];
		$_SESSION['selectedMethod'] = $selectedMethod;
	} else {
		$selectedMethod = $_SESSION['selectedMethod'];
	}
	$currentTTYP = $_SESSION['currentTTYP'];
	
	echo "<h2>Edit Tray Type Info: </h2>";
	

	
	if(isset($_POST['newData'])) {
		$newName = $_POST['newData'];
		
		$sql = "UPDATE ttyp SET name='$newName' WHERE ttyp_id='$currentTTYP'";
		$worker->query($sql);
		
		header("Location: trayTypeDetail.php?ttyp_id=$currentTTYP");
		die();
	} else if(isset($_POST['newcompany'])) { 
	
		$newCompany = $_POST['newcompany'];
		
		$sql = "UPDATE ttyp SET cmp_id='$newCompany' WHERE ttyp_id='$currentTTYP'";
		
		$worker->query($sql);
		
		header("Location: trayTypeDetail.php?ttyp_id=$currentTTYP");
		die();
	
	} else if(isset($_POST['newteams'])) {
		
		$newTeam = $_POST['newteams'];
		
		$sql = "UPDATE ttyp SET team_id='$newTeam' WHERE ttyp_id='$currentTTYP'";
		
		$worker->query($sql);
		
		header("Location: trayTypeDetail.php?ttyp_id=$currentTTYP");
		die();
	
	
	} else {

		if($selectedMethod == "company") $selectedMethod = "cmp_id";
		if($selectedMethod == "team") $selectedMethod = "team_id";
		
		$sql = "SELECT $selectedMethod FROM ttyp WHERE ttyp_id='$currentTTYP'";
		
		if($selectedMethod == "cmp_id") $selectedMethod = "company";
		if($selectedMethod == "team_id") $selectedMethod = "team";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$companySelector = $worker->createSelector("company", "name", "cmp_id", true);
			$teamSelector = $worker->createSelector("teams", "name", "team_id");
		
			$companyChangeForm = "<form method='post' action='editTrayTypeInfo.php'>" .
			"$companySelector  <br/>"  .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			$teamChangeForm = "<form method='post' action='editTrayTypeInfo.php'>" .
			"$teamSelector <br/>" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			$form = "<form method='post' action='editTrayTypeInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";

			if($selectedMethod == "company") {
					if($currentData == 0) $currentData = "Global";
					//echo "$currentData";
					echo $companyChangeForm;
			} else if($selectedMethod == "team") {
				if($currentData == 0) $currentData = "Pending";
				//echo $currentData;
				echo $teamChangeForm;
			
			
			} else {
			
				echo $form;
			}
			
		}
				
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}



?>