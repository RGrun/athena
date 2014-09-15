<?php

	//trayLoan.php
	//this page combines the functionality of the trayreq and trayresp pages
	//its used for making and responding to tray loan requests
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	$htmlUtils->timestampLegend();
	
	$userId = $_SESSION['userId'];
	$teamId = $_SESSION['teamId'];
	$usersCompanies = $_SESSION['userCompanies'];
	
	echo "<div class='landingview'>"; //open landingview
	
	echo "<a href='newRequest.php'>Create New Loan Request</a>";
	
	//print current requests
	echo "<h2>Current Tray Requests: </h2>";
	
	$requests = "<div class='loanRequests'>"; //open loanRequests
	
	$sql = "SELECT * FROM trayreq WHERE status='Pending'";
	//echo $sql;
	
	$result = $worker->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
	
		//print active requests
		extract($row);
		$ttyp = $worker->findTrayType($ttyp_id, "name");
		$user = $worker->findUser($usr_id, "uname");
		$team = $worker->findTeam($team_id, "name");
		
		$start = $worker->checkTime($start);
		$end = $worker->checkTime($end);
		
		
		$requests .= "<div class='trayRequest'>"; //open trayRequest
		
		$requests .= "<div class='trayTypeRequest'>Requested Type: $ttyp</div>" .
		"<div class='userRequest'>Requested By: $user / $team</div>" .
		"<div class='timeRequest'>Needed By: $start</div>" .
		"<div class='returnRequest'>Will Be Returned By: $end</div>" .
		"<div class='dttmRequest'>Requested at: $dttm</div>" .
		"<div class='cmtRequest'>$cmt</div>" .
		"<div class='buttonRequest'><a href='fulfillRequest.php?rid=$req_id'>Fulfill Request</a></div>";
		
		
		
		$requests .= "</div>"; //close trayRequest
	}
	
	$requests .= "</div>"; //end loanRequests
	
	echo $requests;
	
	echo "</div>"; //close landingview
	
	$htmlUtils->makeFooter();
	
?>