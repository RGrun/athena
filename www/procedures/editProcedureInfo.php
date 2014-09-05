<?php

	//editProcedureInfo.php
	
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
	$currentProcedure = $_SESSION['currentProcedureId'];
	
	echo "<h2>Edit Procedure Info: </h2>";
	

	if(isset($_POST['newData'])) {
		$worker->editProcedureDatabase($selectedMethod, $currentProcedure, $_POST['newData']);
		$worker->closeConnection();
	} else if(isset($_POST['newcompany'])) { 
		$worker->editProcedureDatabase("cmp_id", $currentProcedure, $_POST['newcompany']);
		$worker->closeConnection();
	
	} else {

		if($selectedMethod == "company") $selectedMethod = "cmp_id";
		
		$sql = "SELECT $selectedMethod FROM procs WHERE proc_id='$currentProcedure'";
		
		if($selectedMethod == "cmp_id") $selectedMethod = "company";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$companySelector = $worker->createSelector("company", "name", "cmp_id", true);
		
			$companyChangeForm = "<form method='post' action='editProcedureInfo.php'>" .
			"$companySelector  <br/>"  .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			$form = "<form method='post' action='editProcedureInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";

			if($selectedMethod == "company") {
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