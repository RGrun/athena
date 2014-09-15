<?php

	//newRequest.php
	//this is the page where team leaders will be able to create new loan requests
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$userId = $_SESSION['userId'];
	$teamId = $_SESSION['teamId'];
	$userCompanies = $_SESSION['userCompanies'];
	
	//mechanism for creting requested
	if(isset($_POST['confirm'])) {
	
		$newCmt = $_POST['newComment'];
		$newTtyp = $_POST['newTray'];
		
		$newHour = $_POST['newHour'];
		$newMin = $_POST['newMin'];
		$newMonth = $_POST['newMonth'];
		$newDay = $_POST['newDay'];
		$newYear = $_POST['newYear'];
		
		$newHour2 = $_POST['newHour2'];
		$newMin2 = $_POST['newMin2'];
		$newMonth2 = $_POST['newMonth2'];
		$newDay2 = $_POST['newDay2'];
		$newYear2 = $_POST['newYear2'];
		
		$unixTimeStart = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$unixTimeEnd = mktime($newHour2, $newMin2, 0, $newMonth2, $newDay2, $newYear2);
		
		$startDate = date("Y-m-d H:i:s", $unixTimeStart);
		$endDate = date("Y-m-d H:i:s", $unixTimeEnd);
		$newDttm = date("Y-m-d H:i:s", time());
		
		$newSql = "INSERT INTO trayreq (ttyp_id, usr_id, team_id, start, end, dttm, cmt)" .
		" VALUES ('$newTtyp', '$userId', '$teamId', '$startDate', '$endDate', '$newDttm', '$newCmt')";
		//echo $newSql;
		$worker->query($newSql);
		
		//log
		//get new req_id
		$logSql = "SELECT req_id FROM trayreq WHERE ttyp_id='$newTtyp' AND usr_id='$userId' AND dttm='$newDttm'";
		$logResult = $worker->query($logSql);
		$logRow = mysqli_fetch_array($logResult);
	
		$newReqId = $logRow[0];
		
		$requestedTTYP = $worker->findTrayType($newTtyp, "name");
		$worker->logSevent($userId, "new.request", $requestedTTYP, "", "");
		
		$userName = $worker->findUser($userId, "uname");
		//notify team leaders
		$worker->makeNotification(0, $worker->_LOAN_REQUEST, $worker->_TRAY, "$requestedTTYP requested by $userName", date("Y-m-d H:i:s", time()));  

		header("Location: trayLoan.php");
		die();
	}
	
	//create ttyp selector, with filters applied
	$ttypSelect = "<select size='1' name='newTray'>";
		
		//generate selector
		$sql = "SELECT * FROM ttyp";
		$result = $worker->query($sql);
		while ($row = mysqli_fetch_assoc($result)) {
		
			$ttyp_id = $row['ttyp_id'];
			$name = $row['name'];
			
			if($row['team_id'] == $teamId || in_array($row['cmp_id'], $userCompanies)) {
				$ttypSelect .= "<option value='$ttyp_id'>$name</option>";
			}

		}
			
		$ttypSelect .= "</select>";
	
	
	echo "<h2>Create New Loan Request:</h2>";
		
	$dateTime = $worker->makeDateTimeSelect();
	$dateTime2 = $worker->makeDateTimeSelect("2");

	$form = "<form action='newRequest.php' method='post'>" .
	"<table>" .
	"<tr><td>Tray type requested: </td><td>$ttypSelect </td></tr>" .
	"<br/>Needed by: $dateTime <br />" .
	"<br/>Will be returned by: $dateTime2 <br/>" .
	"<tr><td>Comment: </td><td><textarea name='newComment'></textarea> </td></tr>" . 
	"</table>" .
	"<input type='hidden' value='1' name='confirm' />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "$form";
	
	
	
	
	$htmlUtils->makeFooter();

?>