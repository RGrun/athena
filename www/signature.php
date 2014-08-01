<?php

	//signature.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$pickupDropoff = "";
	
	$currentTrayId = $_GET['tid'];
	if(isset($_POST['mtd'])) $pickupDropoff = $_POST['mtd'];
	else $pickupDropoff = $_GET['mtd'];
	
	$_SESSION['currentTrayId'] = $currentTrayId;
	
	//mechanisim for setting the tray's new status
	if(isset($_POST['confirm'])) {
	
		if($pickupDropoff == "Pickup") {
			$sql = "UPDATE trays SET status='Returned' WHERE tray_id='$currentTrayId'";
			$worker->query($sql);
			//echo $sql;
			header("Location: trayInspector.php");
		} else if($pickupDropoff == "Dropoff") {
			$sql = "UPDATE trays SET status='Loaned' WHERE tray_id='$currentTrayId'";
			$worker->query($sql);
			//echo $sql;
			header("location: trayInspector.php");
		}
	
	}
	
	$sql = "SELECT * FROM trays WHERE tray_id='$currentTrayId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h5>Please ensure this information is correct, then input your name in the box below.</h5>";

		
		echo "<h2>Tray $pickupDropoff</h2>";
		
		
		$company = $worker->findCompany($cmp_id, "name");
		$team = $worker->findTeam($team_id, "name");
		$site = $worker->findSite($site_id, "name");
		$loanTeam = $worker->findTeam($loan_team, "name");
		
		$table = "<table>" .
		"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
		"<tr><td><em>Name</em></td><td>$name</td></tr>" .
		"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
		"<tr><td><em>Responsible Team:</em></td><td>$team</td></td></tr>" .
		"<tr><td><em>Current Location</em></td><td>$site</td></tr>" .
		"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td></tr>" .
		"</table>";
		
		echo "$table";
		
		//create traycont table (tray contents)
		$sql = "SELECT * FROM traycont WHERE tray_id='$currentTrayId'";

		if($result = $worker->query($sql)) {
		
			$traycont = "<table>" .
			"<tr><th>Tray Contents:</th></tr>" .
			"<tr><th>Instrument</th><th>Quantity</th><th>State</th><th>Comment</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$instrument = $worker->findInstrument($inst_id, "name");
				
				$traycont .= "<tr><td>$instrument</td>" .
				"<td>$quant</td><td>$state</td><td>$cmt</td></tr>";
				
			}
			
			$traycont .= "</table>";
			
			echo "$traycont";
			
			$confirmForm = "<form action='signature.php?tid=$currentTrayId&mtd=$pickupDropoff' method='post'>" .
			"Enter your full name here: <br/> <input type='text' name='newName' /><br/>" .
			"Accept: <input type='checkbox' name='accept'  onchange='signature()'/> <br/>" .
			"<input type='hidden' name='confirm' value='1' />" .
			"<input id='proceed' type='submit' value='Proceed' disabled /> </form>";
			
			echo $confirmForm;
			
			
		} else {
			echo "Database connection error.";
		}
	}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
?>
		
