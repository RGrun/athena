<?php

	//editUserInfo.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['mtd'])){
		$selectedMethod = $_GET['mtd'];
		$_SESSION['selectedMethod'] = $selectedMethod;
	} else {
		$selectedMethod = $_SESSION['selectedMethod'];
	}
	$currentUser = $_SESSION['currentUserId'];
	
	echo "<h2>Edit User Info: </h2>";
	

	if(isset($_POST['changeActivity'])) {
		$worker->editUserDatabase('active', $currentUser);
		$worker->closeConnection();
	} else if(isset($_POST['newData'])) {
		$worker->editUserDatabase($selectedMethod, $currentUser, $_POST['newData']);
		$worker->closeConnection();
	} else if(isset($_POST['newteams'])) {
		$worker->editUserDatabase($selectedMethod, $currentUser, $_POST['newteams']);
		$worker->closeConnection();
	} else {
		$activityForm = "<form method='post' action='editUserInfo.php'>" .
			"<input type='hidden' name='changeActivity' />" .
			"<input type='submit' value='Change Activity' /> </form> <br />";
			

		
		$sql = "SELECT $selectedMethod FROM users WHERE usr_id='$currentUser'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$teamSelector = $worker->createSelector("teams", "name", "team_id");

			$teamForm = "<form method='post' action='editUserInfo.php'>" .
			"$teamSelector<br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			$form = "<form method='post' action='editUserInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			if($selectedMethod == "active" && $currentData == 1) {
				echo "User is active. <br />";
				echo $activityForm;
			} else if($selectedMethod == "active" && $currentData == 0) {
				echo "User is inactive. <br />";
				echo $activityForm;
			} else if($selectedMethod == "team_id") {
				echo $teamForm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>