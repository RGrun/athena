<?php

	//editProcedureInfo.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
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
	} else {
		$form = "<form method='post' action='editProcedureInfo.php'>" .
		"<textarea name='newData' cols='20' rows='5'>Enter New Data Here</textarea><br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$sql = "SELECT $selectedMethod FROM procs WHERE proc_id='$currentProcedure'";
		
		if($result = $worker->query($sql)) {
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			echo "Current Value: <br />";
			
				echo "<p>$currentData</p>";
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>