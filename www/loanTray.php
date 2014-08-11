<?php

	//loanTray.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$method = $_GET['mtd'];
	$action = $_GET['action'];
	$currentTray = $_GET['tid'];
	
	if(isset($_POST['newteams']) && $action == "loan") {
		$newTeam = $_POST['newteams'];
		$sql = "UPDATE trays SET loan_team='$newTeam' WHERE tray_id='$currentTray'";
		$worker->query($sql);
		if($method == "dropoff") header("Location: dropoff.php");
		else header("Location: pickup.php");
	} else if($action == "return") {
		$sql = "UPDATE trays SET loan_team='0' WHERE tray_id='$currentTray'";
		$worker->query($sql);
		if($method == "dropoff") header("Location: dropoff.php");
		else header("Location: pickup.php");
	}
	
	
	$teamSelector = $worker->createSelector("teams", "name", "team_id");
	
	$loanForm = "<form method='post' action='loanTray.php?tid=$currentTray&mtd=$method&action=loan'>" .
	"Loan tray to: $teamSelector <br/>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo $loanForm;
	
	
	
	$htmlUtils->makeFooter();
	
?>