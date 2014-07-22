<?php

	//editCompanyInfo.php
	

	include_once("htmlUtils.php");
	require_once("./dbWorker.php");
	
	//connect to the DB
	$worker = new dbWorker();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['mtd'])){
		$selectedMethod = $_GET['mtd'];
		$_SESSION['selectedMethod'] = $selectedMethod;
	} else {
		$selectedMethod = $_SESSION['selectedMethod'];
	}
	$currentCompany = $_SESSION['currentCompany'];
	
	echo "<h2>Edit Company Info: </h2>";
	

	if(isset($_POST['changeActivity'])) {
		$worker->editCompanyDatabase('active', $currentCompany);
		$worker->closeConnection();
	} else if(isset($_POST['newData'])) {
		$worker->editCompanyDatabase($selectedMethod, $currentCompany, $_POST['newData']);
		$worker->closeConnection();
	} else {
		$activityForm = "<form method='post' action='editCompanyInfo.php'>" .
			"<input type='hidden' name='changeActivity' />" .
			"<input type='submit' value='Change Activity' /> </form> <br />";
			
		$form = "<form method='post' action='editCompanyInfo.php'>" .
		"<textarea name='newData' cols='20' rows='5'>Enter New Data Here</textarea><br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$sql = "SELECT $selectedMethod FROM company WHERE cmp_id='$currentCompany'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			echo "Current Value: <br />";
			
			if($selectedMethod == "active" && $currentData == 1) {
				echo "Company is active. <br />";
				echo $activityForm;
			} else if($selectedMethod == "active" && $currentData == 0) {
				echo "Company is inactive. <br />";
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
		