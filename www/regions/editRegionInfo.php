<?php

	//editRegionInfo.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_GET['mtd'])){
		$selectedMethod = $_GET['mtd'];
		$_SESSION['selectedMethod'] = $selectedMethod;
	} else {
		$selectedMethod = $_SESSION['selectedMethod'];
	}
	$currentRegion = $_SESSION['currentRegionId'];
	
	echo "<h2>Edit Region Info: </h2>";
	

	if(isset($_POST['newData'])) {
		$worker->editRegionDatabase($selectedMethod, $currentRegion, $_POST['newData']);
		$worker->closeConnection();
	} else if(isset($_POST['newcompany'])) { 
	
		
	
		$worker->editRegionDatabase("cmp_id", $currentRegion, $_POST['newcompany']); 
		$worker->closeConnection();
	} else {


		
		$stateChangeForm = "<form method='post' action='editRegionInfo.php'>" .
		"<input type='text' name='newData' maxLength='2' /><br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$companySelector = $worker->createSelector("company", "name", "cmp_id", true);
		
		$companyChangeForm = "<form method='post' action='editRegionInfo.php'>" .
		"$companySelector  <br/>"  .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		if($selectedMethod == "company") $selectedMethod = "cmp_id";
		
		$sql = "SELECT $selectedMethod FROM regions WHERE reg_id='$currentRegion'";
		
		if($selectedMethod == "cmp_id") $selectedMethod = "company";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$form = "<form method='post' action='editRegionInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			if($selectedMethod == "state") {
				echo "$currentData";
				echo $stateChangeForm;
			} else if($selectedMethod == "company") { 
				if($currentData == 0) $currentData = "Pending";
				echo "$currentData";
				echo $companyChangeForm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>