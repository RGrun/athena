<?php

	//sevents.php
	//this is a general logging table for system events
	//many different system events will be displayed here
	
		require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentUserId = $_SESSION['userId'];
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	//page controls
	if(isset($_GET['pageno'])) $pageNo = (int) $_GET['pageno'];
	else $pageNo = 10;
	 
	 
	 $tableName = "System Events History";
		
	 $pageUrl = "sevents.php";
	 $pageBox = "<input type='text' name='pageno' value='$pageNo' />";
		
	 $logView = "<div class='logTableNav'>" .
	"<span class='logTableName'>$tableName</span>" .
	"<div id='pageControls'><form method='get' action='$pageUrl'>" .
	"$pageBox <input type='submit' value='View Logs' />" .
	"</form></div>";
	
	$explainer = "<p>This page displays various system events that have occured.</p><p>The most recent logs are displayed at the top.</p><p>To view more logs, enter the number of entries you wish to view in the box. Default is 10.</p>";
	
	//begin table printing
	$tableToPrint = "$logView<div class='adminTable'>";
			
	if($pageNo <= 10) $sql = "SELECT * FROM sevents ORDER BY dttm DESC LIMIT 10";
	else {
	
		$sql = "SELECT * FROM sevents ORDER BY dttm DESC LIMIT $pageNo";
	}
	
	$tableToPrint .= "<table>" .
	"<tr><th>Event ID</th><th>By User</th><th>Type of Event</th><th>Field</th><th>Changed From</th><th>Changed To</th><th>Time</th></tr>";
	
	$result = $worker->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		extract($row);
		
		$user = $worker->findUser($u_id, "uname");
		
		$tableToPrint .= "<tr><td>$evt_id</td><td>$user</td><td>$name</td><td>$item</td><td>$was</td><td>$now</td><td>$dttm</td></tr>";
	
	
	}
	
	echo $explainer;
	
	echo $tableToPrint;
	
	$htmlUtils->makeFooter();
?>	
