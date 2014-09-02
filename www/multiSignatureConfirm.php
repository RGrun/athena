<?php

	//multiSignatureConfirm.php
	//This page is like the signature page from the single tray pickup, only for multi-select mode
	//The signature is given here on a pickup

	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$pickupDropoff = $_SESSION['mtd'];
	
	if(isset($_POST['storage'])) {
		$destIsStorage = true;
		$storId = (int) $_POST['storage'];
	
	} else {
	
		$destIsStorage = false;
		$storId = "";
		$destId; //FIX
	}
	
	if(isset($_POST['confirm'])) {
	
		$trays = $_SESSION['tray'];
	
		if($pickupDropoff == "pickup") {
		
			foreach($trays as $currentTray) {
			$sql = "SELECT atnow FROM trays WHERE tray_id='$currentTray'";
			$result = $worker->query($sql);
			$row = mysqli_fetch_array($result);
			
			
			$atStorageNow = ($row[0] == "stor") ? true : false;
			
			$sql = "UPDATE trays SET atnow='usr' , stor_id='0' , site_id='0' WHERE tray_id='$currentTray'";
			echo $sql;
			$worker->query($sql);
			//this is the mechanism for completing assignments. If the tray is being picked up from a site,
			//the related assignment is marked as "complete". The user picking up the tray is then responsible for returning
			//it to storage
			if(!$atStorageNow) {
				$sql = "SELECT asgn_id, tray_id, pu_usr FROM assigns WHERE tray_id='$currentTrayId' AND (pu_usr='$userId' OR pu_usr='0')";
				$result = $worker->query($sql);
				while($row = mysqli_fetch_array($result)) {
					if($row[1] == $currentTrayId && ($row[2] == $userId || $row[2] == 0)) {
						$sql2 = "UPDATE assigns SET status='Complete' WHERE asgn_id='$row[0]'";
						$worker->query($sql2);
					}
				}
			}
			
			$tray = $worker->findTray($currentTrayId, "name");
			$user = $worker->findUser($userId, "uname");
			$worker->logSevent($userId, "pickup.site", $tray , "At site", "With $user"); 
			
			
			//echo $sql;

		
			}
			
		$_SESSION['tray'] = null;
		$_SESSION['mtd'] = null;
		header("Location: pickup.php");
		die();
		} else if ($pickupDropoff == "dropoff" && $destIsStorage) {
		
			foreach($trays as $currentTray) {
			$sql = "UPDATE trays SET atnow='stor' , site_id='0' , stor_id='$storId' WHERE tray_id='$currentTrayId'";
			$worker->query($sql);
			$currentTime = time();
			$currentTime = date("Y-m-d H:i:s", $currentTime);
			$sql = "INSERT INTO h_traystor (tray_id, stor_id, usr_id, dttm) VALUES ('$currentTrayId', '$storId', '$userId', '$currentTime')";
			$worker->query($sql);
			//echo $sql;
			
			$tray = $worker->findTray($currentTrayId, "name");
			$user = $worker->findUser($userId, "uname");
			$dest = $worker->findStorage($storId, "name");
			$worker->logSevent($userId, "dropoff.storage", $tray , "With $user", $dest); 
		}
			$_SESSION['tray'] = null;
			$_SESSION['mtd'] = null;
			header("Location: dropoff.php");
			die();
		
		} else if($pickupDropoff == "dropoff") {
			
			foreach($trays as $currentTray) {
			
			$sql = "UPDATE trays SET atnow='site' , stor_id='0' , site_id='$destId' WHERE tray_id='$currentTray'";
			$worker->query($sql);
			//log signature name in database
			$name = $_POST['newName'];
			$time = time();
			$time = date("Y-m-d H:i:s", $time);
			//figure out case related to assignment
			$sql = "SELECT case_id, pu_usr FROM assigns WHERE do_usr='$userId' AND tray_id='$currentTrayId' ORDER BY do_dttm DESC";
			$result = $worker->query($sql);
			//system assumes closest do_dttm is the current case
			$row = mysqli_fetch_array($result);
			$sql = "INSERT INTO traytrans (tray_id, signer, site_id, from_usr, to_usr, case_id, dttm) VALUES ('$currentTrayId', '$name','$destId', '$userId', '$row[1]', '$row[0]', '$time')";
			//echo $sql;
			$worker->query($sql);
			
			$tray = $worker->findTray($currentTrayId, "name");
			$user = $worker->findUser($userId, "uname");
			$dest = $worker->findSite($destId, "name");
			$worker->logSevent($userId, "dropoff.site", $tray , "With $user", $dest); 

		}
			$_SESSION['tray'] = null;
			$_SESSION['mtd'] = null;
			header("Location: dropoff.php");
			die();
		
		}
	
	}
	
	
	
	$trays = $_SESSION['tray'];
	
	if ($pickupDropoff == "dropoff") echo "<h5>Please ensure this information is correct.</h5>";
	else echo "<h5>Please ensure this information is correct, then input your name in the box below.";
	
	foreach($trays as $currentTray) {
	
		$sql = "SELECT * FROM trays WHERE tray_id='$currentTray'";
		$result = $worker->query($sql);
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<div class='adminTable'>";
		
		$company = $worker->findCompany($cmp_id, "name");
		$team = $worker->findTeam($team_id, "name");
		$site = $worker->findSite($site_id, "name");
		$loanTeam = $worker->findTeam($loan_team, "name");
		$storage = $worker->findStorage($stor_id, "name");
		
		if($loanTeam == null) $loanTeam = "None";
		
		if($atnow == "usr") $status = "With user";
		if($atnow == "site") $status = "At site";
		if($atnow == "stor") $status = "In storage";
		if($atnow == "unk") $status = "Unknown";
		
		$table = "<table>" .
		"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
		"<tr><td><em>Name</em></td><td>$name</td></tr>" .
		"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
		"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
		"<tr><td><em>Current Location</em></td><td>$site</td></tr>" .
		"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
		"<tr><td><em>Stored At: </em></td><td>$storage</td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td></tr>" .
		"</table>";
		
		echo "$table";
		
		//create traycont table (tray contents)
		$sql = "SELECT * FROM traycont WHERE tray_id='$currentTray'";

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
	
		}
	}
	
	$pickupForm = "<form action='multiSignatureConfirm.php' method='post'>" .
	"Accept: <input type='checkbox' name='accept'  onchange='signature()'/> <br/>" .
	"<input type='hidden' name='confirm' value='1' />" .
	"<input id='proceed' type='submit' value='Proceed' disabled /> </form>";
			
	if ($pickupDropoff == "pickup") echo $pickupForm;
	
	$htmlUtils->makeFooter();
	
?>