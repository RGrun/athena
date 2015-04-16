<?php

	# home_updateTrayForTTYP.php
	# AJAX end-point
	
	include_once "includes.php";
	
	$gremlin = new Gremlin();
	
	$newTray = $_POST['newTray'];
	$ttyp_id = $_POST['tray_type'];
	$caseID = $_POST['newCaseId'];

	$sql = "UPDATE case_ttyp SET tray_id='$newTray' WHERE ttyp_id='$ttyp_id' AND case_id='$caseID'";

	mysqli_query($gremlin->connection, $sql);
	
	die();
	
	
	
?>