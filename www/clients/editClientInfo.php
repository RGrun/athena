<?php

	//editClientInfo.php
	
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
	$currentClient = $_SESSION['currentClientId'];
	
	echo "<h2>Edit Client Info: </h2>";
	
	if(isset($_POST['changeActivity'])) {
		$worker->editClientDatabase('active', $currentClient);
		$worker->closeConnection();
	} else if(isset($_POST['newData'])) {
		$worker->editClientDatabase($selectedMethod, $currentClient, $_POST['newData']);
		$worker->closeConnection();
	} else {
		$activityForm = "<form method='post' action='editClientInfo.php'>" .
			"<input type='hidden' name='changeActivity' />" .
			"<input type='submit' value='Change Activity' /> </form> <br />";
			
		$form = "<form method='post' action='editClientInfo.php'>" .
		"<textarea name='newData' cols='20' rows='5'>Enter New Data Here</textarea><br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$sql = "SELECT $selectedMethod FROM clients WHERE cli_id='$currentClient'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			echo "Current Value: <br />";
			
			if($selectedMethod == "active" && $currentData == 1) {
				echo "Client is active. <br />";
				echo $activityForm;
			} else if($selectedMethod == "active" && $currentData == 0) {
				echo "Client is inactive. <br />";
				echo $activityForm;
			} else {
				echo "<p>$currentData</p>";
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>