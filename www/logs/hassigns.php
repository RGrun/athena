<?php

	//hassigns
	//logs when assignments are given to users
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	$currentUserId = $_SESSION['userId'];
	
	//page controls
	if(isset($_GET['pageno'])) $pageNo = (int) $_GET['pageno'];
	else $pageNo = 10;
	 
	 
	 $tableName = "Assignment History";
		
	 $pageUrl = "hassigns.php";
	 $pageBox = "<input type='text' name='pageno' value='$pageNo' />";
		
	 $logView = "<div class='logTableNav'>" .
	"<span class='logTableName'>$tableName</span>" .
	"<div id='pageControls'><form method='get' action='$pageUrl'>" .
	"$pageBox <input type='submit' value='View Logs' />" .
	"</form></div>";
	
	$explainer = "<p>This page displays the history of when users were given assignments.</p><p>The most recent logs are displayed at the top.</p><p>To view more logs, enter the number of entries you wish to view in the box. Default is 10.</p>";
	
	//begin table printing
	$tableToPrint = "$logView<div class='adminTable'>";
			
	if($pageNo <= 10) $sql = "SELECT * FROM h_assigns ORDER BY dttm DESC LIMIT 10";
	else {
	
		$sql = "SELECT * FROM h_assigns ORDER BY dttm DESC LIMIT $pageNo";
	}
	
	$tableToPrint .= "<table>" .
	"<tr><th>Assignment No.</th><th>Action</th><th>Status</th><th>Assigned By</th><th>Assigned To</th><th>Time</th></tr>";
	
	$result = $worker->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		extract($row);
		
		$assignedBy = $worker->findClient($from_usr, "uname");

		if($assignedBy == null) { $assignedBy = $worker->findUser($from_usr, "uname"); }
		
		$assignedTo = $worker->findUser($to_usr, "uname");

		$tableToPrint .= "<tr><td>$asgn_id</td><td>$action</td><td>$status</td><td>$assignedBy</td><td>$assignedTo</td><td>$dttm</td></tr>";
	
	
	}
	
	echo $explainer;
	
	echo $tableToPrint;
	
	$htmlUtils->makeFooter();
	
	
	
	
?>