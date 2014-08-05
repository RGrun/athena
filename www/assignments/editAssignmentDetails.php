<?php

	//editAssignmentDetails.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	
	$currentTrayId = $_SESSION['currentTrayId'];
	
	//check to see if this page was reached from an admin page or a user's page
	if(isset($_GET['su'])) {
		//$backLink = "<h6><a href='assignmentDetail.php?aid=$currentTrayId'>Back to admin page.</a></h6>";
	} else {
		$backLink = "<h6><a href='/athena/www/viewTrayDetail.php?tid=$currentTrayId'>Click here when finished editing</a></h6>";	
	}
	
	if(isset($_GET['aid'])) {
		$currentAsgnId = $_GET['aid'];
	}
	
	if(isset($_POST['newMonth'])) {
		extract($_POST);
		
		$unixTimeDO = mktime($newHour, $newMin, 0, $newMonth, $newDay, $newYear);
		$unixTimePU = mktime($newHour2, $newMin2, 0, $newMonth2, $newDay2, $newYear2);
		
		$doDate = date("Y-m-d H:i:s", $unixTimeDO);
		$puDate = date("Y-m-d H:i:s", $unixTimePU);
		
		if($puDate == "1999-11-30 00:00:00") $puDate = "0000-00-00 00:00:00";
		
	
		$worker->editAssignmentDatabase("do_dttm", $currentAsgnId, $doDate, false);
		$worker->editAssignmentDatabase("pu_dttm", $currentAsgnId, $puDate, false);
		
		echo $newAssign;
		
		if($newAssign == "no") {
			header("Location: /athena/www/viewTrayDetail.php?tid=$currentTrayId");
		} else {
			if($newAssign == "do") $worker->editAssignmentDatabase("do_usr",$currentAsgnId, $_SESSION['userId'], false);
			else if($newAssign == "pu") $worker->editAssignmentDatabase("pu_usr", $currentAsgnId, $_SESSION['userId'], false);
			header("Location: /athena/www/viewTrayDetail.php?tid=$currentTrayId");
		}
		
	} if(isset($_POST['newState'])) {
		$worker->editTrayContents("state", $currentInstId, $_POST['newState'], $currentTrayId);
	} if(isset($_POST['newComment'])) {
		$worker->editTrayContents("cmt", $currentInstId, addSlashes($_POST['newComment']), $currentTrayId);
	}
	
	//create assigns table (tray contents)
	$sql = "SELECT * FROM assigns WHERE asgn_id='$currentAsgnId'";

		if($result = $worker->query($sql)) {
			
			echo "<h2>Modifying Assignemnt No. $currentAsgnId</h2>";
			
			echo $backLink;
	
			$asgn = "<table>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$doDTTM = $worker->checkTime($do_dttm);
				$puDTTM = $worker->checkTime($pu_dttm);
				$dropoffUser = $worker->findUser($do_usr, "uname");
				$pickupUser = $worker->findUser($pu_usr, "uname");
				
				$asgn .= 
							"<tr><td><em>Assignment ID</em></td><td>$asgn_id</td></tr>" .
							"<tr><td><em>Case No</em></td><td>$case_id</td></tr>" .
							"<tr><td><em>Dropped off By</em></td><td>$dropoffUser</td></tr>" .
							"<tr><td><em>Picked up By</em></td><td>$pickupUser</td></tr>" .
							"<tr><td><em>Dropoff Time</em></td><td>$doDTTM</td>" .
							"<tr><td><em>Pickup Time</em></td><td>$puDTTM</td></tr>" .
							"<tr><td><em>Status</em></td><td>$status</td></tr>" .
							"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
							"</table>";
				
			}
			
			$asgn .= "</table>";
			
			echo "<p>$asgn</p>";
		
			$dateTime = $worker->makeDateTimeSelect();
			$dateTime2 = $worker->makeDateTimeSelect(true);
		
		$asgnForm = "<form action='editAssignmentDetails.php?aid=$currentAsgnId' method='post'>" .
		"New Dropoff Time: $dateTime <br/>" .
		"New Pickup Time: $dateTime2 <br/>" .
		
		"No change to assigned users: <input type='radio' name='newAssign' value='no' checked='1' /> <br/>" .
		"Assign self to dropoff: <input type='radio' name='newAssign' value='do' /> <br/>" .
		"Assign self to pickup: <input type='radio' name='newAssign' value='pu' /> <br/><br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<h2>Modify assignment data: </h2>";
		
		echo "<p>$asgnForm</p>";
		

	}
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>
	