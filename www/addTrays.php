<?php

	//addTrays.php
	
	//This page is part three of the reservation process, after case creation and tray type assigning
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	$currentCase = $_GET['cid'];
	
	$userCompanies = $_SESSION['userCompanies'];
	
	//mechanism for adding trays to fufill tray types
	if(isset($_POST['ttyps'])) {
	
		$noOfTyyps = $_POST['noOfTtyps'];
		for($s = 1; $s <= $noOfTyyps; $s++) {
			if(isset($_POST["ttypId" . $s])) {
				$thisTray = $_POST["newTray" . $s];
				$thisTtyp = $_POST["ttypId" . $s];
			
				$addSql = "UPDATE case_ttyp SET tray_id='$thisTray' WHERE case_id='$currentCase' AND ttyp_id='$thisTtyp'";
				//echo $addSql;
				$worker->query($addSql);
			}
		}
	
	
	}
	
	
	$sql = "SELECT * FROM cases WHERE case_id='$currentCase'";

	$result = $worker->query($sql);
	$row = mysqli_fetch_assoc($result);
	
	extract($row);
	
	echo "<h2>Case Details: </h2>";
	
	echo "<div class='adminTable'>";
	
	extract($_POST);
	
	$team = $worker->findTeam($team_id, "name");
	$doc = $worker->findDoctor($doc_id, "name");
	$procedure = $worker->findProcedure($proc_id, "name");
	$siteName = $worker->findSite($site_id, "name");
							
	$caseTable = "<table>" .
	"<tr><td><em>Case ID:</em></td><td>$case_id</td></tr>" .
	"<tr><td><em>Assigned Team:</em></td><td>$team</td></tr>" .
	"<tr><td><em>Doctor:</em></td><td>$doc</td></tr>" .
	"<tr><td><em>Procedure:</em></td><td>$procedure</td></tr>" .
	"<tr><td><em>Site:</em></td><td>$siteName</td></tr>" .
	"<tr><td><em>Status:</em></td><td>Pending</td></tr>" .
	"<tr><td><em>Created At:</em></td><td>$dttm</td></tr>" .
	"<tr><td><em>Comment:</em></td><td>$cmt</td></tr>" .
	"</table>";
	
	echo $caseTable;
	
	//create tray types
	
	$ttypSql = "SELECT * from case_ttyp WHERE case_id='$case_id'";
	$ttypResult = $worker->query($ttypSql);
	
	$ttypRows = "<form method='post' action='addTrays.php?cid=$case_id'>";
	
	$salt = 1;
	while($ttypRow = mysqli_fetch_assoc($ttypResult)) {
	
		extract($ttypRow);
		
		
		
		$trayType = $worker->findTrayType($ttyp_id, "name");
		
		//tray is unfulfilled
		if($tray_id == 0) {
			$ttypRows .= "<div class='ttypUnfulfilled'>";
			$ttypRows .= "<div class='ttypName'><h3>$trayType</h3></div>";
			
			$ttypRows .= "<p>No tray is assigned to this tray type. Please select one to add.</p>";
			
			$ttypRows .= "<input type='hidden' name='ttypId" . $salt . "' value='$ttyp_id' />"; 
			
			$ttypRows .= "<select size='1' name='newTray" . $salt . "' >";
			$ttypRows .= "<option value='0'>Pending</option>"; //default option
			
			
			//figure out which tags will fulfill type
			$goodTags = array();
			$sql2 = "SELECT tag FROM ttyp_tag WHERE ttyp_id='$ttyp_id'";
			$result2 = $worker->query($sql2);
			
			while($row2 = mysqli_fetch_array($result2)) {
				array_push($goodTags, $row2[0]);
			}
			//print_r($goodTags);
			
			//filter out tags that aren't part of user's company
			$sql3 = "SELECT tag, cmp_id FROM tags";
			$result3 = $worker->query($sql3);
			while($row3 = mysqli_fetch_array($result3)) {
				//filter out tags that arent in users company 
				if((!in_array($row3[1], $userCompanies) || $row3[1] != 0)) {
					array_diff($goodTags, array($row3[0]));
				}
			}
			//print_r($goodTags);
			
			$possibleTrays = array();
			//find trays with that tag assigned
			$sql4 = "SELECT tag, tray_id FROM tray_tag";
			$result4 = $worker->query($sql4);
			while($row4 = mysqli_fetch_array($result4)) {
				if(in_array($row4[0], $goodTags)) {
					array_push($possibleTrays, $row4[1]);
				}
			}
			//print_r($possibleTrays);
			
			//$possibleTrays is now an array that contains only tray_ids that fufill the user's company requirements
			foreach($possibleTrays as $tray) {
				$tName = $worker->findTray($tray, "name");
				$ttypRows .= "<option value='$tray'>$tName</option>";
			}
			
			$ttypRows .= "</select></div>";
		
		
		
		//tray is fulfilled
		} else if($tray_id != 0) {
		
			$ttypRows .= "<div class='ttypFulfilled'>";
			$ttypRows .= "<div class='ttypName'><h3>$trayType</h3></div>";
			
			//which tray was assigned?
			$trayName = $worker->findTray($tray_id, "name");
			
			$ttypRows .= "<p>Currently Assigned: <h5>$trayName</h5>. To replace, <a href='replaceTray.php?tid=$tray_id&cid=$case_id&ttyp=$ttyp_id'>click here</a>.</p>";
			
			$ttypRows .= "</div>";
		
		
		}
		
		$salt++;
	}
	
	$salt--;
	
	$ttypRows .= "<input type='submit' value='Add Trays' />";
	$ttypRows .= "<input type='hidden' name='ttyps' value='$ttyp_id' />";
	$ttypRows .= "<input type='hidden' name='noOfTtyps' value='$salt' />";
	$ttypRows .= "</form>";
	
	echo $ttypRows;
	
	echo "</div>";

	//Trays already assigned to case are displayed here
	echo "<div id='trayview'>";

	echo "<h2>Current Trays Assigned to Case: </h2>";	
	
	$sql = "SELECT tray_id FROM assigns INNER JOIN cases ON cases.case_id=assigns.case_id " .
	"WHERE (cases.case_id='$case_id' AND assigns.case_id='$case_id')";
	
	//echo $sql;
	
	$result = $worker->query($sql);
	
	while($row = mysqli_fetch_assoc($result)) {
	
		$tray = $row['tray_id'];
	
		$sql2 = "SELECT * FROM trays WHERE tray_id='$tray'";
		
		$result2 = $worker->query($sql2);
		
		$row2 = mysqli_fetch_assoc($result2);
		
		extract($row2);
		
		echo "<div class='adminTable'>";
		
		$company = $worker->findCompany($cmp_id, "name");
		$team = $worker->findTeam($team_id, "name");
		$site = $worker->findSite($site_id, "name");
		if($site == null) $site = "Storage";
		$loanTeam = $worker->findTeam($loan_team, "name");
		$storage = $worker->findStorage($stor_id, "name");
		
		if($loanTeam == null) $loanTeam = "None";
		
		if($atnow == "usr") $status = "With user";
		if($atnow == "site") $status = "At site";
		if($atnow == "stor") $status = "In storage";
		if($atnow == "unk") $status = "Unknown";
		
		$table = "<table>" .
		"<tr><td><em>Tray ID:</em></td><td>$tray_id</td></tr>" .
		"<tr><td><em>Name:</em></td><td>$name</td></tr>" .
		"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
		"<tr><td><em>Responsible Team:</em></td><td>$team</td></td></tr>" .
		"<tr><td><em>Current Location:</em></td><td>$site</td></tr>" .
		"<tr><td><em>Loaned To:</em></td><td>$loanTeam</td></tr>" .
		"<tr><td><em>Stored At: </em></td><td>$storage</td></tr>" .
		"<tr><td><em>Status:</em></td><td>$status</td></tr>" .
		"<tr><td><a href='deleteTray.php?tid=$tray_id&cid=$currentCase'>Remove Tray</a></td></tt>" .
		"</table>";
		
		echo "$table";
		
		echo "</div>";
	}
	
		
	//This form links to a page where you can add more trays to the case
	$form = "<form method='post' action='newAssignment.php?cid=$case_id'>" .
	"<input type='submit' value='Add new tray to case' /></form>";
	
	
	echo $form;
	
	
	echo "</div>";
		
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>	