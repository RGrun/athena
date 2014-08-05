<?php

	//editAssignmentInfo.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
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
	} else if(isset($_POST['newcases'])) {
		$worker->editAssignmentDatabase("case_id", $currentAssignment, $_POST['newcases']);
		$worker->closeConnection();
	} else if(isset($_POST['newusers'])) {
		if($selectedMethod == "dousr") $worker->editAssignmentDatabase("do_usr", $currentAssignment, $_POST['newusers']);
		else $worker->editAssignmentDatabase("pu_usr", $currentAssignment, $_POST['newusers']);
		$worker->closeConnection();
	} else if(isset($_POST['newtype'])) {
		$worker->editAssignmentDatabase("type", $currentAssignment, $_POST['newtype']);
		$worker->closeConnection();
	}  else if(isset($_POST['newMonth'])) {
		//format dttm string
		extract($_POST);
		$unixTime = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$date = date("Y-m-d H:i:s", $unixTime);

		if($selectedMethod == "dodttm") $worker->editAssignmentDatabase("do_dttm", $currentAssignment, $date);
		else $worker->editAssignmentDatabase("pu_dttm", $currentAssignment, $date);
		$worker->closeConnection();
	} else {


		
		$caseSelector = $worker->createSelector("cases", "case_id", "case_id");
		$traySelector = $worker->createSelector("trays", "name", "tray_id");
		$userSelector = $worker->createSelector("users", "uname", "usr_id", true);
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
		
		$dateSelector = $worker->makeDateTimeSelect();
		
		$statusForm = "<form method='post' action='editAssignmentInfo.php'>" .
		"$statusSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$dodttmForm = "<form method='post' action='editAssignmentInfo.php'>" .
		"$dateSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$pudttmForm = "<form method='post' action='editAssignmentInfo.php'>" .
			"$dateSelector" .
			"<input type='submit' value='Commit Changes' /></form><br/>";
		
		if($selectedMethod == "case") $selectedMethod = "case_id";
		if($selectedMethod == "tray") $selectedMethod = "tray_id";
		if($selectedMethod == "dousr") $selectedMethod = "do_usr";
		if($selectedMethod == "puusr") $selectedMethod = "pu_usr";
		if($selectedMethod == "dodttm") $selectedMethod = "do_dttm";
		if($selectedMethod == "pudttm") $selectedMethod = "pu_dttm";

		$sql = "SELECT $selectedMethod FROM assigns WHERE asgn_id='$currentAssignment'";

		if($result = $worker->query($sql)) {

			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			if($currentData == 0) $currentData = "Pending";
			
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
			} else if($selectedMethod == "do_dttm") {
				echo "<p>$currentData</p>";
				echo $dodttmForm;
			}else if($selectedMethod == "pu_dttm") {
				echo "<p>$currentData</p>";
				//echo "<span id='js'></span><br/>";
				//echo "<span id='js2'></span>";
				echo $pudttmForm;
			} else if($selectedMethod == "do_usr") {
				echo "<p>$currentData</p>";
				echo $userForm;
			} else if($selectedMethod == "pu_usr") { 
				echo "<p>$currentData</p>";
				echo $userForm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>