<?php

	//editStorageInfo.php
	
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
	$currentStorageId = $_SESSION['currentStorageId'];
	
	echo "<h2>Edit Location Info: </h2>";
	

	if(isset($_POST['changeActivity'])) {
		$worker->editStorageDatabase('active', $currentStorageId);
		$worker->closeConnection();
	} else if(isset($_POST['newData'])) {
		$worker->editStorageDatabase($selectedMethod, $currentStorageId, $_POST['newData']);
		$worker->closeConnection(); 
	} else if(isset($_POST['newcompany'])) {
		$worker->editStorageDatabase($selectedMethod, $currentStorageId, $_POST['newcompany']);
		$worker->closeConnection();
	} else {
		$activityForm = "<form method='post' action='editStorageInfo.php'>" .
			"<input type='hidden' name='changeActivity' />" .
			"<input type='submit' value='Change Activity' /> </form> <br />";
			
		$sql = "SELECT $selectedMethod FROM storage WHERE stor_id='$currentStorageId'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$companySelector = $worker->createSelector("company", "name", "cmp_id");

			$companyForm = "<form method='post' action='editStorageInfo.php'>" .
			"$companySelector<br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			$form = "<form method='post' action='editStorageInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			if($selectedMethod == "active" && $currentData == 1) {
				echo "Location is active. <br />";
				echo $activityForm;
			} else if($selectedMethod == "active" && $currentData == 0) {
				echo "Location is inactive. <br />";
				echo $activityForm;
			} else if($selectedMethod == "cmp_id") {
				echo $companyForm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>