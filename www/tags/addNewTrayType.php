<?php

	//addNewTrayType.php
	//for adding a new tray type. Redirect to trayTypeDetail for new tray type after creation
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	
	$usersCompanies = $_SESSION['userCompanies'];
	$teamId = $_SESSION['teamId'];
	
	//tray tag creation mechanism
	if(isset($_POST['creation'])) {
		
		$name = $_POST['newName'];
		$company = $_POST['newCompany'];
		
		$sql = "INSERT INTO ttyp (name, cmp_id, team_id) VALUES ('$name', '$company', '$teamId')";
		
		$worker->query($sql);
		
		$newSql = "SELECT ttyp_id FROM ttyp WHERE name='$name' AND cmp_id='$company' AND team_id='$teamId'";

		$result = $worker->query($newSql);
		$row = mysqli_fetch_array($result); //assumes only one result
		
		$ttyp = $row[0];
		
		header("Location: trayTypeDetail.php?ttyp_id=$ttyp");
		die();
	
	}
	

	echo "<div class='landingview'>";
	
	echo "<h2>Input new tray type data:</h2>";
	
	//create company selector
	if(is_array($usersCompanies)) {
		$companySelector = "<select name='newCompany' size='1'>";
		for($i = 0; $i < count($usersCompanies); $i++) {
			$companyName = $worker->findCompany($usersCompanies[$i], "name");
			$companySelector .= "<option value='$usersCompanies[$i]'>$companyName</option>";
		}
		$companySelector .= "</select>";

	}
	
	

	$form = "<form action='addNewTrayType.php' method='post'>" .
	"<table>" .
	"<tr><td>Tray Type name: </td><td><input type='text' name='newName' /></td></tr>" .
	"<tr><td>New Tray Type's Company: </td><td>$companySelector </td></tr>" .
	"</table>" .
	"<input type='hidden' value='1' name='creation' />" .
	"<input type='submit' value='Create Tray Type' /> </form>";
	
	echo "$form";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
	
	
?>