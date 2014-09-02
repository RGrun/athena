<?php

	//multiSignature.php
	//This page is the multiple select version of the standard signature page
	//it cycles through every tray selected in the previous screen so that the user can check tray contents
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$pickupDropoff = "";
	
	if(!isset($_SESSION['trayIndex'])) {
		$trays = $_POST['tray'];
		$trayIndex = 0;
		//echo $trayIndex;
		$pickupDropoff = $_GET['mtd'];
	} else {
		$trays = $_SESSION['tray'];
		$trayIndex = $_SESSION['trayIndex'];
		//echo $trayIndex;
		$pickupDropoff = $_SESSION['mtd'];
	}
	
	if($trayIndex == count($trays)) {
		//if we reach here, all the trays have been confirmed. This is like a signature.
		
		$_SESSION['trayIndex'] = null;
	
		header("Location: multiSignatureConfirm.php?mtd=$pickupDropoff");
		die();
	}
	
	
	//loop through trays from array
	$thisTray = $trays["$trayIndex"];
	
	$sql = "SELECT * FROM trays WHERE tray_id='$thisTray'";
	
	$result = $worker->query($sql);
	
	$row = mysqli_fetch_assoc($result);
	
		extract($row);
	
		//begin table printing
		echo "<div class='adminTable'>";
		
		if($pickupDropoff == "pickup") echo "<h4>Tray Pickup</h4>";
		else echo "<h4>Tray dropoff</h4>";
		
		echo "<h3>Please ensure this information is correct.</h3>";
		
		$currentIndexNo = $trayIndex + 1;
		
		echo "<h2>Tray #$currentIndexNo / " . count($trays) ."</h2>";
		
		
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
		$sql = "SELECT * FROM traycont WHERE tray_id='$thisTray'";

		if($result = $worker->query($sql)) {
		
			$traycont = "<table>" .
			"<tr><th>Tray Contents:</th></tr>" .
			"<tr><th>Instrument</th><th>Quantity</th><th>State</th><th>Comment</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$instrument = $worker->findInstrument($inst_id, "name");
				
				$traycont .=  "<tr><td>$instrument</td>" .
				"<td>$quant</td><td>$state</td><td>$cmt</td><td class='mod'><a href='/athena/www/trays/editTrayContents.php?iid=$inst_id&mtd=pickup'>Modify</a></td></tr>";
				
			}
			
			$traycont .= "</table>";
			
			echo "$traycont";
			
			$confirmSelector = "<select id='confirm' size='1' onchange='showHide()'>" .
			"<option value='show'>Yes</option>" .
			"<option value='hide'>No, modify contents</option>" .
			"</select>";
			
			echo "Are the contents of the tray consistent with what is displayed here? $confirmSelector<br/>";
			
			$proceedButton = "<form action='multiSignature.php' method='post'>" .
			"<input id='proceedButton' type='submit' value='Next Tray' /> </form>";
			
			echo $proceedButton;
			
			$_SESSION['tray'] = $trays;
			$_SESSION['trayIndex'] = $trayIndex + 1;
			$_SESSION['mtd'] = $pickupDropoff;
			
			$htmlUtils->makeFooter();
			$worker->closeConnection();
		}
			
	
	?>