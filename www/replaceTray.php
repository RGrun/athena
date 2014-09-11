<?php

	//replaceTray.php
	//used to replace the tray currently fulfilling the tray type
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$currentCase = $_GET['cid'];
	
	$userId = $_SESSION['userId'];
	
	$userCompanies = $_SESSION['userCompanies'];
	
	$ttyp_id = $_GET['ttyp'];
	$tray_id = $_GET['tid'];
	
	if(isset($_POST['confirm'])) {
	
		$newTray = $_POST['newTray'];
	
		$sql2 = "UPDATE case_ttyp SET tray_id=$newTray WHERE case_id='$currentCase' AND ttyp_id='$ttyp_id'";
		$worker->query($sql2);
		
		header("Location: addTrays.php?cid=$currentCase");
		die();
	
	}
	
	$sql = "SELECT tray_id FROM case_ttyp WHERE ttyp_id='$ttyp_id' AND case_id='$currentCase' AND tray_id='$tray_id'";
	$result = $worker->query($sql);
	
	$row = mysqli_fetch_array($result);
	
	$currentData = $row[0];
	
	$ttypName = $worker->findTrayType($currentData, "name");
	$trayName = $worker->findtray($tray_id, "name");
	
	echo "<h2> Select new tray to fulfill $ttypName: </h2>";
	
	$ttypSelect = "<select size='1' name='newTray'>";
	//$ttypSelect .= "<option value='0'>Pending</option>"; //default option
	
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
			$ttypSelect .= "<option value='$tray'>$tName</option>";
		}
			
		$ttypSelect .= "</select>";
		
		echo $trayName;
		
		$form = "<form action='replaceTray.php?tid=$tray_id&cid=$currentCase&ttyp=$ttyp_id' method='post'>" .
		"$ttypSelect <br/>" .
		"<input type='hidden' name='confirm' value='1' />" .
		"<input type='submit' value='Confirm Change' /> </form>";
		
		echo $form;
	
	
?>