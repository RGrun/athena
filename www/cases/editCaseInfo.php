<?php

	//editCaseInfo.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_GET['mtd'])){
		$selectedMethod = $_GET['mtd'];
		$_SESSION['selectedMethod'] = $selectedMethod;
	} else {
		$selectedMethod = $_SESSION['selectedMethod'];
	}
	$currentCase = $_SESSION['currentCaseId'];
	
	echo "<h2>Edit Case Info: </h2>";
	

	if(isset($_POST['newData'])) {
		//echo "data";
		$worker->editCaseDatabase($selectedMethod, $currentCase, $_POST['newData']);
		$worker->closeConnection();
	} else if(isset($_POST['newteams'])) {
		//echo "teams";
		$worker->editCaseDatabase("team_id", $currentCase, $_POST['newteams']);
		$worker->closeConnection();
	} else if(isset($_POST['newdoctors'])) {
		//echo "docs";
		$worker->editCaseDatabase("doc_id", $currentCase, $_POST['newdoctors']);
		$worker->closeConnection();
	} else if(isset($_POST['newprocs'])) {
		//echo "procs";
		$worker->editCaseDatabase("proc_id", $currentCase, $_POST['newprocs']);
		$worker->closeConnection();
	} else if(isset($_POST['newsites'])) {
		//echo "sites";
		$worker->editCaseDatabase("site_id", $currentCase, $_POST['newsites']);
		$worker->closeConnection();
	} else if (isset($_POST['newStatus'])) {
		
		//echo "status";
		$worker->editCaseDatabase("status", $currentCase, $_POST['newStatus']);
		$worker->closeConnection();
	} else if(isset($_POST['newMonth'])) {
		//format dttm string
		extract($_POST);
		$unixTime = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$date = date("Y-m-d H:i:s", $unixTime);
		
		//echo $sql;
		$worker->editCaseDatabase("dttm", $currentCase, $date);
		$worker->closeConnection();
	} else {


		
		$teamSelector = $worker->createSelector("teams", "name", "team_id");
		$doctorSelector = $worker->createSelector("doctors", "name", "doc_id");
		$procedureSelector = $worker->createSelector("procs", "name", "proc_id");
		$siteSelector = $worker->createSelector("sites", "name", "site_id");
		
		$teamForm ="<form method='post' action='editCaseInfo.php'>" .
		"$teamSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$doctorForm = "<form method='post' action='editCaseInfo.php'>" .
		"$doctorSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$procedureForm = "<form method='post' action='editCaseInfo.php'>" .
		"$procedureSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$siteForm = "<form method='post' action='editCaseInfo.php'>" .
		"$siteSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$statusSelector = "<select name='newStatus' size='1'>" .
		"<option value='Pending'>Pending</option>" .
		"<option value='Complete'>Complete</option>" .
		"</select>";
		
		$statusForm = "<form method='post' action='editCaseInfo.php'>" .
		"$statusSelector<br/>" .
		"<input type='submit' value='Commit Changes' /> </form><br/>";
		
		if($selectedMethod == "team") $selectedMethod = "team_id";
		if($selectedMethod == "doctor") $selectedMethod = "doc_id";
		if($selectedMethod == "procedure") $selectedMethod = "proc_id";
		if($selectedMethod == "site") $selectedMethod = "site_id";

		$sql = "SELECT $selectedMethod FROM cases WHERE case_id='$currentCase'";

		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$form = "<form method='post' action='editCaseInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			if($selectedMethod == "team_id") {
				$currentData = $worker->findTeam($currentData, "name");
				echo "<p>$currentData</p>";
				echo $teamForm;
			} else if($selectedMethod == "doc_id") {
				$currentData = $worker->findDoctor($currentData, "name");
				echo "<p>$currentData</p>";
				echo $doctorForm;
			} else if($selectedMethod == "proc_id") {
				$currentData = $worker->findProcedure($currentData, "name");
				echo "<p>$currentData</p>";
				echo $procedureForm;
			} else if ($selectedMethod == "site_id") {
				$currentData = $worker->findSite($currentData, "name");
				echo "<p>$currentData</p>";
				echo $siteForm;
			} else if ($selectedMethod == "status") {
				echo "<p>$currentData</p>";
				echo $statusForm;
			} else if($selectedMethod == "dttm") {
				echo "<p>$currentData</p>";
				//echo "<span id='js'></span><br/>";
				//echo "<span id='js2'></span>";
				$dttm = $worker->makeDateTimeForm("editCaseInfo.php?cid=$currentCase");
				echo $dttm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>