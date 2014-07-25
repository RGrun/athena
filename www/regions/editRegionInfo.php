<?php

	//editRegionInfo.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
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
	} else {

		$form = "<form method='post' action='editRegionInfo.php'>" .
		"<textarea name='newData' cols='20' rows='5'>Enter New Data Here</textarea><br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$stateChangeForm = "<form method='post' action='editRegionInfo.php'>" .
		"<input type='text' name='newData' maxLength='2' /><br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$sql = "SELECT $selectedMethod FROM regions WHERE reg_id='$currentRegion'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			echo "Current Value: <br />";
			
			if($selectedMethod == "state") {
				echo "<p>$currentData</p>";
				echo $stateChangeForm;
			} else {
				echo "<p>$currentData</p>";
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>