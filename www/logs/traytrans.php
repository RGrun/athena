<?php 

	//traytrans.php
	//this logging table provides a history of each tray's little adventure through the system
	//when trays are picked up or dropped off, it will be logged here
	
	//this script assumes trays are returned at the end of a case; dropoffs are logged but pickups are not
	
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
	 
	 
	 $tableName = "Tray Transfer History";
		
	 $pageUrl = "traytrans.php";
	 $pageBox = "<input type='text' name='pageno' value='$pageNo' />";
		
	 $logView = "<div class='logTableNav'>" .
	"<span class='logTableName'>$tableName</span>" .
	"<div id='pageControls'><form method='get' action='$pageUrl'>" .
	"$pageBox <input type='submit' value='View Logs' />" .
	"</form></div>";
	
	$explainer = "<p>This logging table provides a history of each tray's dropoff history. Try dropoffs are recorded, but pickups are not.</p><p>This log assumes trays are picked up at the end of a case.</p><p>The most recent logs are displayed at the top.</p><p>To view more logs, enter the number of entries you wish to view in the box. Default is 10.</p>";
	
	//begin table printing
	$tableToPrint = "$logView<div class='adminTable'>";
			
	if($pageNo <= 10) $sql = "SELECT * FROM traytrans ORDER BY dttm DESC LIMIT 10";
	else {
	
		$sql = "SELECT * FROM traytrans ORDER BY dttm DESC LIMIT $pageNo";
	}
	
	$tableToPrint .= "<table>" .
	"<tr><th>Transfer ID</th><th>Tray</th><th>Signed For By</th><th>At</th><th>Dropped Off By</th><th>User to Pickup</th><th>For Case</th><th>Dropoff Time</th></tr>";
	
	$result = $worker->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		extract($row);
		
		$DOuser = $worker->findUser($from_usr, "uname");
		$PUuser = $worker->findUser($to_usr, "uname");
		$tray = $worker->findTray($tray_id, "name");
		$site = $worker->findSite($site_id, "name");
		
		
		$tableToPrint .= "<tr><td>$tran_id</td><td>$tray</td><td>$signer</td><td>$site</td><td>$DOuser</td><td>$PUuser</td><td>$case_id</td><td>$dttm</td></tr>";
	
	
	}
	
	echo $explainer;
	
	echo $tableToPrint;
	
	$htmlUtils->makeFooter();
?>	

	