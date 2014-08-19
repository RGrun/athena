<?php

	//htraycont.php
	//this logging table shows a history of when tray contents were changed
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentUserId = $_SESSION['userId'];
	
	//page controls
	if(isset($_GET['pageno'])) $pageNo = (int) $_GET['pageno'];
	else $pageNo = 10;
	 
	 
	 $tableName = "Tray Contents History";
		
	 $pageUrl = "htraycont.php";
	 $pageBox = "<input type='text' name='pageno' value='$pageNo' />";
		
	 $logView = "<div class='logTableNav'>" .
	"<span class='logTableName'>$tableName</span>" .
	"<div id='pageControls'><form method='get' action='$pageUrl'>" .
	"$pageBox <input type='submit' value='View Logs' />" .
	"</form></div>";
	
	$explainer = "<p>This page displays the history of when the contents of a tray was changed.</p><p>The most recent logs are displayed at the top.</p><p>To view more logs, enter the number of entries you wish to view in the box. Default is 10.</p>";
	
	//begin table printing
	$tableToPrint = "$logView<div class='adminTable'>";
			
	if($pageNo <= 10) $sql = "SELECT * FROM h_traycont ORDER BY dttm DESC LIMIT 10";
	else {
	
		$sql = "SELECT * FROM h_traycont ORDER BY dttm DESC LIMIT $pageNo";
	}
	
	$tableToPrint .= "<table>" .
	"<tr><th>Tray</th><th>Instrument</th><th>New Quantity</th><th>New State</th><th>Comment</th><th>Time</th></tr>";
	
	$result = $worker->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		extract($row);
		
		$instrument = $worker->findInstrument($inst_id, "name");
		$tray = $worker->findTray($tray_id, "name");
		
		$tableToPrint .= "<tr><td>$tray</td><td>$instrument</td><td>$quant</td><td>$state</td><td>$cmt</td><td>$dttm</td></tr>";
	
	
	}
	
	echo $explainer;
	
	echo $tableToPrint;
	
	$htmlUtils->makeFooter();
?>	
