<?php

	//editInstrumentInfo.php
	
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
	$currentInstrument = $_SESSION['currentInstrumentId'];
	
	echo "<h2>Edit Instrument Info: </h2>";
	

	if(isset($_POST['newData'])) {
		$worker->editInstrumentDatabase($selectedMethod, $currentInstrument, $_POST['newData']);
		$worker->closeConnection();
	} else {

		
		$sql = "SELECT $selectedMethod FROM instruments WHERE inst_id='$currentInstrument'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$form = "<form method='post' action='editInstrumentInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();

?>