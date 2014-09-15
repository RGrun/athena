<?php

	//fulfillRequest.php
	//team leaders can choose to loan trays here after one is requested
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$userId = $_SESSION['userId'];
	$teamId = $_SESSION['teamId'];
	$userCompanies = $_SESSION['userCompanies'];
	
	$req_id = $_GET['rid'];
	
	//figure out ttyp_id
	$reqSql = "SELECT ttyp_id FROM trayreq WHERE req_id='$req_id'";
	$reqResult = $worker->query($reqSql);
	$reqRow = mysqli_fetch_array($reqResult);
	
	$ttyp_id = $reqRow[0];
	
	//loan mechanism
	if(isset($_POST['confirm'])) {
	
		$tray_id = $_POST['newTray'];
		$newComment = $_POST['newComment'];
		$now = date("Y-m-d H:i:s", time());
		
		$newSql = "INSERT INTO trayresp (req_id, usr_id, team_id, tray_id, status, dttm, cmt)" .
		" VALUES ('$req_id', '$userId', '$teamId', '$tray_id', 'Sent', '$now', '$newComment')";
		$worker->query($newSql);
		
		
		
		//log
		$trayToAdd = $worker->findTray($tray_id, "name");
		$worker->logSevent($userId, "fulfilled.request", $trayToAdd, "", "");
		
		$targetSql = "SELECT team_id FROM trayreq WHERE req_id='$req_id'";
		$targetResult = $worker->query($targetSql);
		$targetRow = mysqli_fetch_array($targetResult);
		
		$targetTeam = $targetRow[0];
		$targetTeamName = $worker->findTeam($targetTeam, "name");
		
		//update tray's status
		$traySql = "UPDATE trays SET loan_team='$targetTeam' WHERE tray_id='$tray_id'";
		//echo $traySql;
		$worker->query($traySql);
		
		//notify team members of loaned tray
		$worker->makeNotification($teamId, $worker->_LOAN_REPLY, $worker->_TRAY, "$trayToAdd loaned to $targetTeamName", date("Y-m-d H:i:s", time()));  
		
		$fufillingTeam = $worker->findTeam($teamId, "name");
		
		$worker->makeNotification($targetTeam, $worker->_LOAN_REPLY, $worker->_TRAY, "$trayToAdd received on loan from $fufillingTeam<br/> $newComment", date("Y-m-d H:i:s", time()));  
		
		//update trayreq 
		$updateSql = "UPDATE trayreq SET status='Loaned' WHERE req_id='$req_id'";
		$worker->query($updateSql);
		
		header("Location: trayLoan.php");
		die();
	
	}

	
	$ttypSelect = "<select size='1' name='newTray'>";

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
		
		$alreadyPrintedTrays = array();
		//$possibleTrays is now an array that contains only tray_ids that fufill the user's company requirements
		foreach($possibleTrays as $tray) {
			if(!in_array($tray, $alreadyPrintedTrays)) {
				$tName = $worker->findTray($tray, "name");
				$ttypSelect .= "<option value='$tray'>$tName</option>";
				array_push($alreadyPrintedTrays, $tray);
			}
		}
			
		$ttypSelect .= "</select>";

	echo "<div class='landingview'>"; //open landing
	
	$needed = $worker->findTrayType($ttyp_id, "name");
	
	echo "<h2>Select a $needed tray to loan: </h2>";

	$form = "<form method='post' action='fulfillRequest.php?rid=$req_id'>" .
	"$ttypSelect <br/><br/>" .
	"Comment: <textarea name='newComment'></textarea><br/>" .
	"<input type='hidden' value='1' name='confirm' />" .
	"<input type='submit' value='Loan Tray' /></form>";
	
	echo $form;



	echo "</div>"; //close landingview

	$htmlUtils->makeFooter();


?>