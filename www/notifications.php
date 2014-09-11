<?php

	//notifications.php
	//this is the user notification page
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$teamId = $_SESSION['teamId'];
	
	//mechanism for hiding notifications
	if(isset($_GET['hide'])) {
	
		$un = $_GET['un_id'];
	
		$hideSql = "UPDATE unotifs SET hidden='1' WHERE un_id='$un'";
		$worker->query($hideSql);
	}
	
	
	echo "<div class='adminTable'>"; //open adminTable
	
	echo "<h2>Your Notifications</h2>";
	
	echo "<p>These are events that require your attention.</p><p>Click 'Hide' to remove an event from this list.</p>";
	
	
	$sql = "SELECT * FROM unotifs WHERE usr_id='$teamId' AND hidden='0'";
	
	$result = $worker->query($sql);
	
	$notifs = "<table>"; //open table
	$notifs .= "<tr><th>Type</th><th>Relates To</th><th>Message</th><th>Time</th><th>Notification Created</th></tr>";
	
	while($row = mysqli_fetch_assoc($result)) {
	
		extract($row);
		
		$notifs .= "<tr>";
	
		$notType = "";
		switch($not_id) {
			case 1:
				$notType = "Loan Request";
				break;
			case 2:
				$notType = "Loan Reply";
				break;
			case 3:
				$notType = "Tray Picked Up";
				break;
			case 4:
				$notType = "Case Reminder";
				break;
			case 5:
				$notType = "Tray Relinquished";
				break;
			case 6:
				$notType = "Tray Unassigned";
				break;
			case 7:
				$notType = "New Case Created";
				break;
			case 8:
				$notType = "Tray Late";
				break;
			default:
				$notType = "ERROR!";

		}
	
	
		$notifs .= "<td>$notType</td>";
		
		$notItem = "";
		switch ($item_id) {
			case 1: 
				$notItem = "Request";
				break;
			case 2:
				$notItem = "Tray";
				break;
			case 3:
				$notItem = "Case";
				break;
			default:
				$notItem = "ERROR!";
		}
	
		$notifs .= "<td>$notItem</td>";
		
		$notifs .= "<td>$msg</td>";
		
		$notifs .= "<td>$dttm</td>";
		
		$notifs .= "<td>$evdttm</td>";
		
		$notifs .= "<td><a href='notifications.php?hide=1&un_id=$un_id'>Hide</a></td>";
	
		$notifs .= "</tr>";
		
		
		//set viewed time for every element in list, if not already set
		if($vwdttm == "0000-00-00 00:00:00") { 
			$vwDttm = date("Y-m-d H:i:s", time());
	
			$sql2 = "UPDATE unotifs SET vwdttm='$vwDttm' WHERE un_id=$un_id";
			$worker->query($sql2);
		
		}
	}
	
	$notifs .= "</table>"; //close table
	
	echo $notifs;
	
	
	//echo "<a href='notifications.php?hideAll=1'>Hide All Notifications</a>";
	//echo "<p>WARNING: This effect cannot be undone.</p>";
	
	echo "</div>"; //close landingview
	
	
	
	$htmlUtils->makeFooter();
	
?>