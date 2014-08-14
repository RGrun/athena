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
	
	
	$sql = "SELECT * FROM trays WHERE tray_id='$currentTrayId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);

		$siteId = null;
		
		if(isset($_SESSION['destIsStorage'])) $destIsStorage = $_SESSION['destIsStorage'];
		else $destIsStorage = false;
		
		if(isset($_POST['newsites'])) $siteId = $_POST['newsites'];
		if($pickupDropoff == "dropoff" && preg_match('/stor/', $siteId)) {
			$destId = (int) substr($siteId, 4);
			$destName = $worker->findStorage($destId, "name");
			$destIsStorage = true;
			$_SESSION['destIsStorage'] = $destIsStorage;
		} else if ($pickupDropoff == "dropoff") {
			$destId = $siteId;
			$destName = $worker->findSite($destId, "name");
		} else if($pickupDropoff == "pickup") {
			$destId = $siteId;
			$destName = "";
		}
		
		if ($destIsStorage) echo "<h5>Please ensure this information is correct.</h5>";
		else echo "<h5>Please ensure this information is correct, then input your name in the box below.";
		
		echo "<h2>Tray $pickupDropoff</h2>";
		
		if($pickupDropoff == "dropoff") echo "<h2>Destination: $destName </h2>";
		
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
			
			$dropoffForm = "<form action='signature.php?tid=$currentTrayId&mtd=$pickupDropoff' method='post'>" .
			"Enter your full name here: <br/> <input type='text' name='newName' /><br/>" .
			"Accept: <input type='checkbox' name='accept'  onchange='signature()'/> <br/>" .
			"<input type='hidden' name='confirm' value='1' />" .
			"<input type='hidden' name='updatedSite' value='$destId' />" .
			"<input id='proceed' type='submit' value='Proceed' disabled /> </form>";
			
			$pickupForm = "<form action='signature.php?tid=$currentTrayId&mtd=$pickupDropoff' method='post'>" .
			"Accept: <input type='checkbox' name='accept'  onchange='signature()'/> <br/>" .
			"<input type='hidden' name='confirm' value='1' />" .
			"<input type='hidden' name='updatedSite' value='$destId' />" .
			"<input id='proceed' type='submit' value='Proceed' disabled /> </form>";
			
			if ($pickupDropoff == "pickup" || $destIsStorage == true) echo $pickupForm;
			else if($pickupDropoff== "dropoff") echo $dropoffForm;
			
			
		} else {
			echo "Database connection error.";
		}
	}
	//echo $destIsStorage;
	//mechanisim for setting the tray's new status and site
	if(isset($_POST['confirm'])) {
	
		if(isset($_POST['newName'])) $clientName = $_POST['newName'];
	
		if($pickupDropoff == "pickup") {
			//$destId = $_POST['updatedSite'];
			$sql = "UPDATE trays SET atnow='usr' , stor_id='0' , site_id='0' WHERE tray_id='$currentTrayId'";
			$worker->query($sql);
			//echo $sql;
			header("Location: pickup.php");
		} else if($destIsStorage == true) {
			$destId = $_POST['updatedSite'];
			$sql = "UPDATE trays SET atnow='stor' , site_id='0' , stor_id='$destId' WHERE tray_id='$currentTrayId'";
			$worker->query($sql);
			//$sql = "UPDATE assigns SET cli_nm='$clientName' WHERE tray_id='$currentTrayId'";
			//$worker->query($sql);
			//echo $sql;
			$_SESSION{'destIsStorage'} = null;
			header("Location: dropoff.php");
		} else if ($destIsStorage == false) {
			$destId = $_POST['updatedSite'];
			$sql = "UPDATE trays SET atnow='site' , stor_id='0' , site_id='$destId' WHERE tray_id='$currentTrayId'";
			$worker->query($sql);
			//log signature name in database
			//echo $sql;
			header("Location: dropoff.php");
		}
	
	}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
?>
		
