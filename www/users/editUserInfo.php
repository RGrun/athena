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
	} else if(isset($_POST['newPerm'])) {
		$worker->editUserDatabase($selectedMethod, $currentUser, $_POST['newPerm']);
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
			
			$permText = "<p><span class='warning'>WARNING: Before removing admin permissions, please ensure that at least one other user still has admin permissions. <br/> If no users have admin permissions, then nobody will be able to access administrator functions from the web interface.</span></p><p>This is where you can change which users have access to various regions of the system. <br/> To modify, enter a value from the table below into the text box and click &#39;Commit Changes&#39; to confirm.</p><div class='adminTable'><table><tr><td><em>Administrator access</em></td><td>admin+</td></tr></table><p>Affected user will need to log out and in again to see the changes.</p></div>";

			$teamForm = "<form method='post' action='editUserInfo.php'>" .
			"$teamSelector<br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
			
			$permForm = "<form method='post' action='editUserInfo.php'>" .
			"$permText <br/>" .
			"<input type='text' name='newPerm' value='$currentData' />" .
			"<input type='submit' value='Commit Changes'/></form>";
			
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
			} else if($selectedMethod == "perm"){
				echo $permForm;
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>