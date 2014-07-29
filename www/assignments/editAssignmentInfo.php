<?php

	//editAssignmentInfo.php
	
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
	$currentAssignment = $_SESSION['currentAssignmentId'];
	
	echo "<h2>Edit Assignment Info: </h2>";
	

	if(isset($_POST['newData'])) {
		$worker->editAssignmentDatabase($selectedMethod, $currentAssignment, $_POST['newData']);
		$worker->closeConnection();
	} else if(isset($_POST['newtrays'])) {
		$worker->editAssignmentDatabase("tray_id", $currentAssignment, $_POST['newtrays']);
		$worker->closeConnection();
	} else if(isset($_POST['newclients'])) {
		$worker->editAssignmentDatabase("cli_id", $currentAssignment, $_POST['newclients']);
		$worker->closeConnection();
	} else if(isset($_POST['newusers'])) {
		$worker->editAssignmentDatabase("usr_id", $currentAssignment, $_POST['newusers']);
		$worker->closeConnection();
	} else if(isset($_POST['newtype'])) {
		$worker->editAssignmentDatabase("type", $currentAssignment, $_POST['newtype']);
		$worker->closeConnection();
	} else {


		
		$caseSelector = $worker->createSelector("cases", "case_id", "case_id");
		$traySelector = $worker->createSelector("trays", "name", "tray_id");
		$userSelector = $worker->createSelector("users", "uname", "usr_id");
		$clientSelector = $worker->createSelector("clients", "uname", "cli_id");
	
		$caseForm ="<form method='post' action='editAssignmentInfo.php'>" .
		"$caseSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$trayForm = "<form method='post' action='editAssignmentInfo.php'>" .
		"$traySelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$userForm = "<form method='post' action='editAssignmentInfo.php'>" .
		"$userSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$clientForm = "<form method='post' action='editAssignmentInfo.php'>" .
		"$clientSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$statusSelector = "<select name='newData' size='1'>" .
		"<option value='Pending'>Pending</option>" .
		"<option value='Overdue'>Overdue</option>" .
		"<option value='Complete'>Complete</option>" .
		"</select>";
		
		$kindSelector = "<select name='newData' size='1'>" . 
		"<option value='1'>Dropoff</option>" .
		"<option value='2'>Pickup</option>" .
		"</select>";
		
		$statusForm = "<form method='post' action='editAssignmentInfo.php'>" .
		"$statusSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$kindForm = "<form method='post' action='editAssignmentInfo.php'>" .
		"$kindSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		if($selectedMethod == "case") $selectedMethod = "case_id";
		if($selectedMethod == "tray") $selectedMethod = "tray_id";
		if($selectedMethod == "user") $selectedMethod = "usr_id";
		if($selectedMethod == "client") $selectedMethod = "cli_id";

		$sql = "SELECT $selectedMethod FROM assigns WHERE asgn_id='$currentAssignment'";

		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$form = "<form method='post' action='editAssignmentInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			echo "Current Value: <br />";
			
			if($selectedMethod == "case_id") {
				echo "<p>$currentData</p>";
				echo $caseForm;
			} else if($selectedMethod == "tray_id") {
				$currentData = $worker->findtray($currentData, "name");
				echo "<p>$currentData</p>";
				echo $trayForm;
			} else if($selectedMethod == "usr_id") {
				$currentData = $worker->findUser($currentData, "uname");
				echo "<p>$currentData</p>";
				echo $userForm;
			} else if ($selectedMethod == "cli_id") {
				$currentData = $worker->findClient($currentData, "uname");
				echo "<p>$currentData</p>";
				echo $clientForm;
			} else if($selectedMethod == "status") {
				echo "<p>$currentData</p>";
				echo $statusForm;
			} else if($selectedMethod == "kind") {
				echo "<p>$currentData</p>";
				echo $kindForm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>