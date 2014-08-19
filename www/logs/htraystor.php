<?php

	//htraystor.php
	//log table for tray storage
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentUserId = $_SESSION['userId'];
	
	//page controls
	if(isset($_GET['pageno'])) $pageNo = (int) $_GET['pageno'];
	else $pageNo = 10;
	 
	 
	 $tableName = "Tray Storage History";
		
	 $pageUrl = "htraystor.php";
	 $pageBox = "<input type='text' name='pageno' value='$pageNo' />";
		
	 $logView = "<div class='logTableNav'>" .
	"<span class='logTableName'>$tableName</span>" .
	"<div id='pageControls'><form method='get' action='$pageUrl'>" .
	"$pageBox <input type='submit' value='View Logs' />" .
	"</form></div>";
	
	$explainer = "<p>This page displays the history of when trays are put into storage.</p><p>The most recent logs are displayed at the top.</p><p>To view more logs, enter the number of entries you wish to view in the box. Default is 10.</p>";
	
	//begin table printing
	$tableToPrint = "$logView<div class='adminTable'>";
			
	if($pageNo <= 10) $sql = "SELECT * FROM h_traystor ORDER BY dttm DESC LIMIT 10";
	else {
	
		$sql = "SELECT * FROM h_traystor ORDER BY dttm DESC LIMIT $pageNo";
	}
	
	$tableToPrint .= "<table>" .
	"<tr><th>Tray ID</th><th>Tray Name</th><th>Sored At</th><th>Stored By</th><th>Time</th></tr>";
	
	$result = $worker->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		extract($row);
		
		$storage = $worker->findStorage($stor_id, "name");
		$user = $worker->findUser($usr_id, "uname");
		$tray = $worker->findTray($tray_id, "name");
		
		$tableToPrint .= "<tr><td>$tray_id</td><td>$tray</td><td>$storage</td><td>$user</td><td>$dttm</td></tr>";
	
	
	}
	
	echo $explainer;
	
	echo $tableToPrint;
	
	$htmlUtils->makeFooter();
?>	
