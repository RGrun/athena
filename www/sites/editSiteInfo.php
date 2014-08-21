<?php

	//editSiteInfo.php
	
	require_once "includes.php";
	
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
	$currentSite = $_SESSION['currentSiteId'];
	
	echo "<h2>Edit Site Info: </h2>";
	

	if(isset($_POST['changeActivity'])) {
		$worker->editSiteDatabase('active', $currentSite);
		$worker->closeConnection();
	} else if(isset($_POST['newData'])) {
		$worker->editSiteDatabase($selectedMethod, $currentSite, $_POST['newData']);
		$worker->closeConnection();
	} else {
		$activityForm = "<form method='post' action='editSiteInfo.php'>" .
			"<input type='hidden' name='changeActivity' />" .
			"<input type='submit' value='Change Activity' /> </form> <br />";
			

		
		$sql = "SELECT $selectedMethod FROM sites WHERE site_id='$currentSite'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$form = "<form method='post' action='editSiteInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			if($selectedMethod == "active" && $currentData == 1) {
				echo "Site is active. <br />";
				echo $activityForm;
			} else if($selectedMethod == "active" && $currentData == 0) {
				echo "Site is inactive. <br />";
				echo $activityForm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>