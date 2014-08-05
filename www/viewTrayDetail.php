<?php

	//viewTrayDetail.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentTrayId = $_GET['tid'];
	$currentUserId = $_SESSION['userId'];
	
	$_SESSION['currentTrayId'] = $currentTrayId;
	
	$confirmSelector = "<select id='confirm' size='1' onchange='showHide()'>" .
	"<option value='show'>Yes</option>" .
	"<option value='hide'>No, modify contents</option>" .
	"</select>";
	
	$pickupSelector = "<select name='mtd' size='1'>" .
	"<option value='Pickup'>Pickup</option>" .
	"<option value='Dropoff'>Dropoff</option></select>";
	
	//make assignment filter dropdown
	echo "Assignments this tray is part of: ";
	echo $worker->makeAssignmentDropdown($currentTrayId, $currentUserId);
	
	//echo "<span id='js'></span>"; //for debugging

	//make related assignment table in trayView
	$sql = "SELECT * FROM assigns WHERE tray_id='$currentTrayId' AND (do_usr='$currentUserId' OR pu_usr='$currentUserId') OR status='Pending'";
	//echo $sql;
	$result = $worker->query($sql);
	while($row = mysqli_fetch_assoc($result)) {
	
		$newTable = $worker->makeTrayAssignments($row);
		$assignment = $row['asgn_id'];
	
		echo "<div style='display: none;' class='assignment$assignment'>$newTable</div>";
	
	}
	
	
	
	$sql = "SELECT * FROM trays WHERE tray_id='$currentTrayId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h2>Tray Detail</h2>";
		
		
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
				"<td>$quant</td><td>$state</td><td>$cmt</td><td class='mod'><a href='/athena/www/trays/editTrayContents.php?iid=$inst_id'>Modify</a></td></tr>";
				
			}
			
			$traycont .= "</table>";
			
			echo "$traycont";
			
			echo "Are the contents of the tray consistent with what is displayed here? $confirmSelector<br/>";
			
			$proceedButton = "<form action='signature.php?tid=$tray_id' method='post'>" .
			"Are you picking up, or dropping off the tray? $pickupSelector <br/>".
			"<input id='proceedButton' type='submit' value='Proceed' /> </form>";
			
			echo $proceedButton;
			
		}


		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>