<?php

	//editCompanyInfo.php
	

	require_once "includes.php";
	
	//connect to the DB
	$worker = new dbWorker();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
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

		
		$sql = "SELECT $selectedMethod FROM company WHERE cmp_id='$currentCompany'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
						
			$form = "<form method='post' action='editCompanyInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			if($selectedMethod == "active" && $currentData == 1) {
				echo "Company is active. <br />";
				//echo $currentData;
				echo $activityForm;
			} else if($selectedMethod == "active" && $currentData == 0) {
				echo "Company is inactive. <br />";
				//echo $currentData;
				echo $activityForm;
			} else {
				echo "Current value: $currentData";
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>
		