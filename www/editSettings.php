<?php

	//editSettings.php
	//this script is like a combination of editUserInfo and editClientInfo, though stripped down for regular users
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$worker = new dbWorker();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentUser = $_SESSION['userId'];
	$isClient = $_SESSION['isClient'];
	
	
	//Editing for users
	if(!$isClient) {
	
		if(isset($_GET['mtd'])){
			$selectedMethod = $_GET['mtd'];
			$_SESSION['selectedMethod'] = $selectedMethod;
		} else {
			$selectedMethod = $_SESSION['selectedMethod'];
		}

		echo "<h2>Edit Personal Info: </h2>";

		 if(isset($_POST['newData'])) {
			$worker->editUserDatabase($selectedMethod, $currentUser, $_POST['newData'], true);
			$worker->closeConnection();
		} else if (isset($_POST['newPwd'])) {
			$pwd = $_POST['newPwd'];
			$pwd = md5($pwd);
			$worker->editUserDatabase($selectedMethod, $currentUser, $pwd, true);
			$worker->closeConnection();
		} else {
			
			$sql = "SELECT $selectedMethod FROM users WHERE usr_id='$currentUser'";
			
			if($result = $worker->query($sql)) {
				
				$row = mysqli_fetch_array($result);
				
				$currentData = $row[0];
				
				$teamSelector = $worker->createSelector("teams", "name", "team_id");
				
				$form = "<form method='post' action='editSettings.php'>" .
				"<input type='text' name='newData' value='$currentData' /> <br/>" .
				"<input type='submit' value='Commit Changes' /></form>";
				
				$error = "<span id='pwdError' class='error'></span>";
				
				$pwdForm = "<form method='post' action='editSettings.php'>" .
				"<table>".
				"<tr>$error</tr>" .
				"<tr><td>Input New Password: </td><td><input type='password' id='pwd1'/></td></tr>".
				"<tr><td>Re-Enter Password: </td><td><input type='password' id='pwd2' name='newPass' onBlur='checkPass()' /> </td></tr>" .
				"</table>" .
				"<input type='submit' value='Commit Changes' id='pwdSubmit' /> </form>";
				
				 
				if($selectedMethod == "pwd" )  {
					echo "<p>Input new Password.</p>";
					echo $pwdForm;
				} else {
					echo "<p>Input new data.</p>";
					echo $form;
				}
				
			}
		}
	} else if($isClient) {
	
		if(isset($_GET['mtd'])){
			$selectedMethod = $_GET['mtd'];
			$_SESSION['selectedMethod'] = $selectedMethod;
		} else {
			$selectedMethod = $_SESSION['selectedMethod'];
		}
		
		echo "<h2>Edit Personal Info: </h2>";
		
		if(isset($_POST['newData'])) {
			$worker->editClientDatabase($selectedMethod, $currentUser, $_POST['newData'], true);
			$worker->closeConnection();
		} else if (isset($_POST['newPwd'])) {
			$pwd = $_POST['newPwd'];
			$pwd = md5($pwd);
			$worker->editClientDatabase($selectedMethod, $currentUser, $pwd, true);
			$worker->closeConnection();
		} else {

			$sql = "SELECT $selectedMethod FROM clients WHERE cli_id='$currentUser'";
			
			if($result = $worker->query($sql)) {
				
				$row = mysqli_fetch_array($result);
				
				$currentData = $row[0];
				
				$form = "<form method='post' action='editSettings.php'>" .
				"<input type='text' name='newData' value='$currentData' /> <br/>" .
				"<input type='submit' value='Commit Changes' /></form> <br/>";
				
				$error = "<span id='pwdError' class='error'></span>";
				
				$pwdForm = "<form method='post' action='editSettings.php'>" .
				"<table>".
				"<tr>$error</tr>" .
				"<tr><td>Input New Password: </td><td><input type='password' id='pwd1'/></td></tr>".
				"<tr><td>Re-Enter Password: </td><td><input type='password' id='pwd2' name='newPass' onBlur='checkPass()'  /> </td></tr>" .
				"</table>" .
				"<input type='submit' value='Commit Changes' id='pwdSubmit' /> </form>";
				
				if($selectedMethod == "pwd"){
					echo "<p>Input new Password.</p>";
					echo $pwdForm;
				} else {
					echo "<p>Input new data.</p>";
					echo $form;
				}
			}
		}
	}

	$htmlUtils->makeFooter();
	$worker->closeConnection();
?>